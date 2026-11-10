<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipantQrScanTest extends TestCase
{
    use RefreshDatabase;

    public function test_participant_can_scan_presence_qr_and_status_becomes_attended(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Seminar Teknologi Cloud',
            'slug' => 'seminar-teknologi-cloud',
            'category' => 'Seminar',
            'format' => 'offline',
            'location' => 'Auditorium',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
            'is_presence_open' => true,
        ]);

        $registration = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-CLOUD-01',
            'qr_pass' => 'PASS-CLOUD-01',
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
        ]);

        $response = $this->actingAs($peserta)->postJson(route('peserta.presence.scan'), [
            'qr_data' => route('events.presence', $event->slug),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'event_title' => 'Seminar Teknologi Cloud',
        ]);

        $registration->refresh();
        $this->assertEquals('attended', $registration->attendance_status);
        $this->assertNotNull($registration->attended_at);
        $this->assertEquals('Scan QR Sesi Aula', $registration->attendance_gate);
    }

    public function test_participant_cannot_scan_if_presence_is_closed(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Workshop UI Design',
            'slug' => 'workshop-ui-design',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab 1',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 30,
            'price' => 0,
            'status' => 'published',
            'is_presence_open' => false,
        ]);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-UI-01',
            'qr_pass' => 'PASS-UI-01',
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
        ]);

        $response = $this->actingAs($peserta)->postJson(route('peserta.presence.scan'), [
            'qr_data' => route('events.presence', $event->slug),
        ]);

        $response->assertStatus(422);
        $response->assertJson(['status' => 'error']);
    }

    public function test_participant_cannot_scan_if_unpaid(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Pelatihan AI Bedah',
            'slug' => 'pelatihan-ai-bedah',
            'category' => 'Pelatihan',
            'format' => 'offline',
            'location' => 'Lab AI',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 30,
            'price' => 100000,
            'status' => 'published',
            'is_presence_open' => true,
        ]);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-AI-01',
            'qr_pass' => 'PASS-AI-01',
            'payment_status' => 'pending',
            'attendance_status' => 'unattended',
            'amount_paid' => 100000,
        ]);

        $response = $this->actingAs($peserta)->postJson(route('peserta.presence.scan'), [
            'qr_data' => $event->slug,
        ]);

        $response->assertStatus(422);
        $response->assertJson(['status' => 'error']);
    }

    public function test_scan_with_raw_slug_and_token(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Webinar Cyber Security',
            'slug' => 'webinar-cyber-security',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '13:00:00',
            'end_time' => '15:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
            'is_presence_open' => true,
        ]);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-CYBER-01',
            'qr_pass' => null,
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
        ]);

        $response = $this->actingAs($peserta)->postJson(route('peserta.presence.scan'), [
            'qr_data' => 'webinar-cyber-security',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_organizer_can_scan_participant_qr_pass_for_offline_checkin(): void
    {
        $organizer = User::factory()->create(['role' => 'penyelenggara']);
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Simposium Nasional Kedokteran 2026',
            'slug' => 'simposium-nasional-kedokteran-2026',
            'category' => 'Seminar',
            'format' => 'offline',
            'location' => 'Grand Ballroom',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'quota' => 100,
            'price' => 50000,
            'status' => 'published',
        ]);

        $registration = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-SIMP-01',
            'qr_pass' => 'PASS-9982-AMANDA',
            'payment_status' => 'paid',
            'amount_paid' => 50000,
            'attendance_status' => 'unattended',
        ]);

        $response = $this->actingAs($organizer)->postJson(route('organizer.workspace.quick_checkin', ['event' => $event->id]), [
            'code' => 'PASS-9982-AMANDA',
            'source' => 'camera',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'registration' => [
                'registration_code' => 'REG-2026-SIMP-01',
                'qr_pass' => 'PASS-9982-AMANDA',
            ],
        ]);

        $registration->refresh();
        $this->assertTrue($registration->is_checked_in);
        $this->assertEquals('unattended', $registration->attendance_status);
        $this->assertNotNull($registration->checked_in_at);
        $this->assertEquals('Scan QR Pass (Pintu Masuk)', $registration->check_in_gate);
    }

    public function test_organizer_cannot_checkin_online_event(): void
    {
        $organizer = User::factory()->create(['role' => 'penyelenggara']);
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Webinar Cloud Security',
            'slug' => 'webinar-cloud-security',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
        ]);

        $registration = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-ONLINE-01',
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
        ]);

        $response = $this->actingAs($organizer)->postJson(route('organizer.workspace.quick_checkin', ['event' => $event->id]), [
            'code' => 'REG-2026-ONLINE-01',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['status' => 'error']);
    }

    public function test_organizer_can_toggle_checkin_and_attendance_separately(): void
    {
        $organizer = User::factory()->create(['role' => 'penyelenggara']);
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Konferensi AI',
            'slug' => 'konferensi-ai',
            'category' => 'Konferensi',
            'format' => 'offline',
            'location' => 'Ballroom',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
        ]);

        $registration = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-CONF-01',
            'qr_pass' => 'PASS-CONF-01',
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
            'is_checked_in' => false,
        ]);

        $this->actingAs($organizer)->post(route('organizer.checkin.toggle', $registration->id));
        $registration->refresh();
        $this->assertTrue($registration->is_checked_in);
        $this->assertEquals('unattended', $registration->attendance_status);

        $this->actingAs($organizer)->post(route('organizer.attendance.toggle', $registration->id));
        $registration->refresh();
        $this->assertTrue($registration->is_checked_in);
        $this->assertEquals('attended', $registration->attendance_status);
    }

    public function test_participant_portal_shows_qr_pass_only_for_offline_events(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $offlineEvent = Event::create([
            'title' => 'Workshop UI/UX Offline',
            'slug' => 'workshop-ui-ux-offline',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab 3',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $offlineEvent->id,
            'registration_code' => 'REG-OFFLINE-01',
            'qr_pass' => 'PASS-OFFLINE-01',
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
            'is_checked_in' => false,
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('api.qrserver.com');
        $response->assertSee('#PASS-OFFLINE-01');
        $response->assertSee('Check-in: Belum');
        $response->assertSee('Presensi: Belum');
    }

    public function test_participant_portal_hides_qr_pass_for_online_events(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $onlineEvent = Event::create([
            'title' => 'Webinar AI Online',
            'slug' => 'webinar-ai-online',
            'category' => 'Webinar',
            'format' => 'online',
            'virtual_meeting_url' => 'https://meet.google.com/abc-defg-hij',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $onlineEvent->id,
            'registration_code' => 'REG-ONLINE-01',
            'qr_pass' => null,
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
            'is_checked_in' => false,
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.dashboard'));
        $response->assertStatus(200);
        $response->assertDontSee('api.qrserver.com');
        $response->assertDontSee('QR Pass Registrasi Ulang');
        $response->assertDontSee('Check-in: Belum');
        $response->assertSee('Presensi: Belum');
        $response->assertSee('https://meet.google.com/abc-defg-hij');
    }

    public function test_organizer_workspace_renders_checkin_column_only_for_offline_events(): void
    {
        $organizer = User::factory()->create(['role' => 'penyelenggara']);

        $offlineEvent = Event::create([
            'title' => 'Seminar Offline 2026',
            'slug' => 'seminar-offline-2026',
            'category' => 'Seminar',
            'format' => 'offline',
            'location' => 'Gedung A',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        $onlineEvent = Event::create([
            'title' => 'Webinar Online 2026',
            'slug' => 'webinar-online-2026',
            'category' => 'Webinar',
            'format' => 'online',
            'virtual_meeting_url' => 'https://zoom.us/j/123456789',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '13:00:00',
            'end_time' => '15:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
        ]);

        $offlineResponse = $this->actingAs($organizer)->get(route('organizer.workspace', ['event' => $offlineEvent->id, 'tab' => 'peserta']));
        $offlineResponse->assertStatus(200);
        $offlineResponse->assertSee('Check-in (Pintu Masuk)');
        $offlineResponse->assertSee('Pindai QR Pass');

        $onlineResponse = $this->actingAs($organizer)->get(route('organizer.workspace', ['event' => $onlineEvent->id, 'tab' => 'peserta']));
        $onlineResponse->assertStatus(200);
        $onlineResponse->assertDontSee('Check-in (Pintu Masuk)');
        $onlineResponse->assertDontSee('Pindai QR Pass');
        $onlineResponse->assertSee('Presensi Sesi');
    }
}
