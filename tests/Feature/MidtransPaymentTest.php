<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MidtransPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('midtrans.server_key', 'test-server-key');
        Config::set('midtrans.client_key', 'test-client-key');
        Config::set('midtrans.is_production', false);
    }

    public function test_registration_for_paid_event_sets_status_pending_and_requests_snap_token(): void
    {
        Http::fake([
            '*/snap/v1/transactions' => Http::response(['token' => 'mock-snap-token-999'], 200),
        ]);

        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Simposium AI Bedah',
            'slug' => 'simposium-ai-bedah',
            'category' => 'Simposium',
            'format' => 'offline',
            'location' => 'Aula 1',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(2),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 150000,
            'status' => 'published',
        ]);

        $response = $this->actingAs($peserta)->post(route('events.register', $event->slug), [
            'institution' => 'RSUD Jakarta',
            'phone' => '081234567890',
            'agree_terms' => '1',
        ]);

        $reg = Registration::where('user_id', $peserta->id)->where('event_id', $event->id)->first();
        $this->assertNotNull($reg);
        $response->assertRedirect(route('payment.invoice', $reg->registration_code));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('registrations', [
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'payment_status' => 'pending',
            'amount_paid' => 150000,
            'snap_token' => 'mock-snap-token-999',
        ]);
    }

    public function test_registration_for_free_event_sets_status_free(): void
    {
        \Illuminate\Support\Facades\Notification::fake();

        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Webinar Gratis RME',
            'slug' => 'webinar-gratis-rme',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(3),
            'start_time' => '13:00:00',
            'end_time' => '15:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
        ]);

        $response = $this->actingAs($peserta)->post(route('events.register', $event->slug), [
            'agree_terms' => '1',
        ]);

        $response->assertRedirect(route('peserta.dashboard', ['tab' => 'tiket']));

        $this->assertDatabaseHas('registrations', [
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'payment_status' => 'free',
            'amount_paid' => 0,
        ]);

        \Illuminate\Support\Facades\Notification::assertSentTo($peserta, \App\Notifications\TicketIssuedNotification::class);
    }

    public function test_get_snap_token_endpoint_returns_json_token(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Workshop Radiologi',
            'slug' => 'workshop-radiologi',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab 1',
            'start_date' => now()->addDays(4),
            'end_date' => now()->addDays(4),
            'start_time' => '09:00:00',
            'end_time' => '16:00:00',
            'quota' => 30,
            'price' => 200000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-PAY-1',
            'qr_pass' => 'PASS-PAY-1',
            'payment_status' => 'pending',
            'amount_paid' => 200000,
            'snap_token' => 'existing-token-777',
        ]);

        $response = $this->actingAs($peserta)->postJson(route('payment.snap_token', $reg->id));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'snap_token' => 'existing-token-777',
        ]);
    }

    public function test_midtrans_notification_settlement_updates_registration_to_paid(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Kursus ECG Kilat',
            'slug' => 'kursus-ecg-kilat',
            'category' => 'Kursus',
            'format' => 'offline',
            'location' => 'Lab 2',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(5),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'quota' => 20,
            'price' => 250000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-ECG-01',
            'qr_pass' => 'PASS-ECG-01',
            'payment_status' => 'pending',
            'amount_paid' => 250000,
        ]);

        $orderId = 'REG-2026-ECG-01-1731170000';
        $statusCode = '200';
        $grossAmount = '250000';
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . 'test-server-key');

        $response = $this->postJson(route('midtrans.notification'), [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $reg->refresh();
        $this->assertEquals('paid', $reg->payment_status);
        $this->assertEquals('qris', $reg->payment_method);
        $this->assertEquals(250000, $reg->amount_paid);
        $this->assertNotNull($reg->paid_at);
    }

    public function test_midtrans_notification_rejects_invalid_signature(): void
    {
        $response = $this->postJson(route('midtrans.notification'), [
            'order_id' => 'REG-FAKE-01',
            'status_code' => '200',
            'gross_amount' => '100000',
            'signature_key' => 'invalid-hash-here',
            'transaction_status' => 'settlement',
        ]);

        $response->assertStatus(400);
    }

    public function test_peserta_can_cancel_pending_registration(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Webinar Cloud Security',
            'slug' => 'webinar-cloud-security',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(5),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 75000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-CANCEL-01',
            'qr_pass' => 'PASS-CANCEL-01',
            'payment_status' => 'pending',
            'amount_paid' => 75000,
        ]);

        $response = $this->actingAs($peserta)->delete(route('peserta.registration.cancel', $reg->id));

        $response->assertRedirect(route('peserta.dashboard', ['tab' => 'tiket']));
        $this->assertDatabaseMissing('registrations', ['id' => $reg->id]);
    }

    public function test_peserta_cannot_cancel_paid_registration(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Webinar DevSecOps',
            'slug' => 'webinar-devsecops',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(5),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 75000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-PAID-01',
            'qr_pass' => 'PASS-PAID-01',
            'payment_status' => 'paid',
            'amount_paid' => 75000,
        ]);

        $response = $this->actingAs($peserta)->delete(route('peserta.registration.cancel', $reg->id));

        $this->assertDatabaseHas('registrations', ['id' => $reg->id]);
        $response->assertSessionHas('error');
    }

    public function test_pending_registration_cannot_check_in(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Simposium Big Data',
            'slug' => 'simposium-big-data',
            'category' => 'Simposium',
            'format' => 'online',
            'start_date' => now(),
            'end_date' => now(),
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'quota' => 50,
            'price' => 100000,
            'status' => 'published',
            'is_presence_open' => true,
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-PENDING-CHECKIN',
            'qr_pass' => 'PASS-PENDING-CHECKIN',
            'payment_status' => 'pending',
            'amount_paid' => 100000,
        ]);

        $response = $this->actingAs($peserta)->post(route('events.presence_submit', $event->slug));
        $response->assertSessionHas('error');

        $reg->refresh();
        $this->assertNotEquals('attended', $reg->attendance_status);
    }

    public function test_organizer_quick_checkin_blocks_pending_registration(): void
    {
        $organizer = User::factory()->create(['role' => 'penyelenggara']);
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Bootcamp Flutter',
            'slug' => 'bootcamp-flutter',
            'category' => 'Bootcamp',
            'format' => 'offline',
            'location' => 'Lab Komputer 3',
            'start_date' => now(),
            'end_date' => now(),
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'quota' => 30,
            'price' => 300000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-FLUTTER-01',
            'qr_pass' => 'PASS-FLUTTER-01',
            'payment_status' => 'pending',
            'amount_paid' => 300000,
        ]);

        $response = $this->actingAs($organizer)->post(route('organizer.workspace.quick_checkin', $event->id), [
            'code' => $reg->registration_code,
        ]);

        $response->assertSessionHas('error');
        $reg->refresh();
        $this->assertNotEquals('attended', $reg->attendance_status);
    }

    public function test_check_status_endpoint_updates_registration_when_settlement_on_midtrans(): void
    {
        Http::fake([
            '*/v2/*/status' => Http::response([
                'status_code' => '200',
                'transaction_status' => 'settlement',
                'payment_type' => 'bank_transfer',
                'gross_amount' => '150000.00',
            ], 200),
        ]);

        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Webinar AI Python',
            'slug' => 'webinar-ai-python',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(2),
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'quota' => 50,
            'price' => 150000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-CHECK-01',
            'qr_pass' => 'PASS-CHECK-01',
            'payment_status' => 'pending',
            'midtrans_order_id' => 'REG-2026-CHECK-01-999',
            'amount_paid' => 150000,
        ]);

        $response = $this->actingAs($peserta)->postJson(route('payment.check_status', $reg->id));

        $response->assertStatus(200);
        $response->assertJson(['status' => 'paid']);

        $reg->refresh();
        $this->assertEquals('paid', $reg->payment_status);
        $this->assertEquals('bank_transfer', $reg->payment_method);
        $this->assertNotNull($reg->paid_at);
    }

    public function test_check_status_endpoint_keeps_pending_when_not_settled(): void
    {
        Http::fake([
            '*/v2/*/status' => Http::response([
                'status_code' => '201',
                'transaction_status' => 'pending',
                'payment_type' => 'qris',
                'gross_amount' => '50000.00',
            ], 200),
        ]);

        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Workshop Git',
            'slug' => 'workshop-git',
            'category' => 'Workshop',
            'format' => 'online',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(2),
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'quota' => 50,
            'price' => 50000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-PEND-01',
            'qr_pass' => 'PASS-PEND-01',
            'payment_status' => 'pending',
            'midtrans_order_id' => 'REG-2026-PEND-01-111',
            'amount_paid' => 50000,
        ]);

        $response = $this->actingAs($peserta)->postJson(route('payment.check_status', $reg->id));

        $response->assertStatus(200);
        $response->assertJson(['status' => 'pending']);

        $reg->refresh();
        $this->assertEquals('pending', $reg->payment_status);
    }

    public function test_user_can_view_invoice_page_for_pending_registration(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Workshop UI/UX Figma',
            'slug' => 'workshop-uiux-figma',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab 3',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(5),
            'start_time' => '09:00:00',
            'end_time' => '15:00:00',
            'quota' => 30,
            'price' => 75000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-INV-01',
            'qr_pass' => 'PASS-INV-01',
            'payment_status' => 'pending',
            'amount_paid' => 75000,
            'snap_token' => 'mock-token-inv',
        ]);

        $response = $this->actingAs($peserta)->get(route('payment.invoice', $reg->registration_code));

        $response->assertStatus(200);
        $response->assertSee('REG-2026-INV-01');
        $response->assertSee('Workshop UI/UX Figma');
        $response->assertSee('Menunggu Pembayaran');
        $response->assertSee('Bayar Sekarang');
        $response->assertDontSee('Midtrans Snap');
        $response->assertSee('Batalkan');
    }

    public function test_unauthorized_user_cannot_view_other_users_invoice(): void
    {
        $peserta1 = User::factory()->create(['role' => 'peserta']);
        $peserta2 = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Webinar Cloud Computing',
            'slug' => 'webinar-cloud-computing',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(2),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 50000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta1->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-SECRET-01',
            'qr_pass' => 'PASS-SECRET-01',
            'payment_status' => 'pending',
            'amount_paid' => 50000,
        ]);

        $response = $this->actingAs($peserta2)->get(route('payment.invoice', $reg->registration_code));
        $response->assertStatus(403);
    }

    public function test_invoice_page_for_paid_registration_shows_lunas(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Bootcamp Flutter Mobile',
            'slug' => 'bootcamp-flutter-mobile',
            'category' => 'Bootcamp',
            'format' => 'offline',
            'location' => 'Lab Mobile',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(12),
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'quota' => 25,
            'price' => 200000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-PAID-01',
            'qr_pass' => 'PASS-PAID-01',
            'payment_status' => 'paid',
            'amount_paid' => 200000,
            'paid_at' => now(),
            'payment_method' => 'qris',
        ]);

        $response = $this->actingAs($peserta)->get(route('payment.invoice', $reg->registration_code));

        $response->assertStatus(200);
        $response->assertSee('REG-2026-PAID-01');
        $response->assertSee('Lunas');
        $response->assertSee('Pembayaran terverifikasi');
        $response->assertSee('Buka E-Tiket di Portal Peserta');
    }
}
