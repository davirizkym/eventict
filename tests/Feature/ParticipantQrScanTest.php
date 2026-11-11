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
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
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
            'is_checked_in' => true,
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
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
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
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
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
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
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
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
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
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
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

    public function test_offline_participant_cannot_scan_presence_before_checking_in(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Simposium AI Offline',
            'slug' => 'simposium-ai-offline',
            'category' => 'Seminar',
            'format' => 'offline',
            'location' => 'Auditorium Grha',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
            'is_presence_open' => true,
        ]);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-SIMP-OFFLINE',
            'qr_pass' => 'PASS-SIMP-01',
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
            'is_checked_in' => false,
        ]);

        $response = $this->actingAs($peserta)->postJson(route('peserta.presence.scan'), [
            'qr_data' => route('events.presence', $event->slug),
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Anda belum melakukan registrasi ulang (check-in) di lokasi kegiatan. Silakan tunjukkan QR Pass Anda ke panitia di meja registrasi terlebih dahulu.',
        ]);
    }

    public function test_participant_cannot_register_for_completed_or_past_event(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $pastTime = now()->subHours(2);
        $pastHourEvent = Event::create([
            'title' => 'Workshop Hari Ini Sudah Lewat',
            'slug' => 'workshop-hari-ini-sudah-lewat',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab ICT',
            'start_date' => $pastTime->copy()->subHours(2)->toDateString(),
            'end_date' => $pastTime->toDateString(),
            'start_time' => $pastTime->copy()->subHours(2)->format('H:i:s'),
            'end_time' => $pastTime->format('H:i:s'),
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        $this->assertTrue($pastHourEvent->isPassed());

        $response = $this->actingAs($peserta)->get(route('events.register.form', $pastHourEvent->slug));
        $response->assertRedirect(route('events.show', $pastHourEvent->slug));
        $response->assertSessionHas('error', 'Pendaftaran untuk kegiatan ini telah ditutup karena kegiatan telah selesai.');
    }

    public function test_participant_can_cancel_free_ticket_before_event_starts(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $futureEvent = Event::create([
            'title' => 'Webinar Masa Depan',
            'slug' => 'webinar-masa-depan',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $futureEvent->id,
            'registration_code' => 'REG-FREE-FUTURE',
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
            'is_checked_in' => false,
        ]);

        $response = $this->actingAs($peserta)->delete(route('peserta.registration.cancel', $reg->id));
        $response->assertRedirect(route('peserta.dashboard', ['tab' => 'tiket']));
        $this->assertDatabaseMissing('registrations', ['id' => $reg->id]);
    }

    public function test_organizer_can_unattend_participant_and_certificate_access_is_revoked(): void
    {
        $organizer = User::factory()->create(['role' => 'penyelenggara']);
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Seminar Keamanan Data',
            'slug' => 'seminar-keamanan-data',
            'category' => 'Seminar',
            'format' => 'offline',
            'location' => 'Auditorium',
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-CERT-01',
            'payment_status' => 'free',
            'attendance_status' => 'attended',
            'is_checked_in' => true,
        ]);

        \App\Models\Certificate::create([
            'registration_id' => $reg->id,
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'certificate_number' => 'CERT-001',
            'verify_hash' => 'HASH-001',
            'download_url' => 'storage/certificates/sample.pdf',
            'issued_at' => now(),
        ]);

        $portalResponse = $this->actingAs($peserta)->get(route('peserta.dashboard', ['tab' => 'sertifikat']));
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('CERT-001');

        $response = $this->actingAs($organizer)->post(route('organizer.attendance.toggle', $reg->id));
        $response->assertSessionHas('success');
        $reg->refresh();
        $this->assertEquals('unattended', $reg->attendance_status);

        $portalRevoked = $this->actingAs($peserta)->get(route('peserta.dashboard', ['tab' => 'sertifikat']));
        $portalRevoked->assertStatus(200);
        $portalRevoked->assertDontSee('CERT-001');
    }

    public function test_pending_registration_expires_after_10_minutes_allowing_reregistration(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Bootcamp Python',
            'slug' => 'bootcamp-python',
            'category' => 'Pelatihan',
            'format' => 'online',
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
            'quota' => 1,
            'price' => 50000,
            'status' => 'published',
        ]);

        $oldReg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-EXPIRED-01',
            'payment_status' => 'pending',
            'attendance_status' => 'unattended',
        ]);
        Registration::where('id', $oldReg->id)->update(['created_at' => now()->subMinutes(15)]);

        $response = $this->actingAs($peserta)->get(route('events.register.form', $event->slug));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('registrations', ['id' => $oldReg->id]);
    }

    public function test_virtual_meeting_link_is_hidden_when_event_has_passed_realtime_by_end_time(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $pastEnd = now()->subHour();
        $passedEvent = Event::create([
            'title' => 'Webinar Lewat Jadwal',
            'slug' => 'webinar-lewat-jadwal',
            'category' => 'Webinar',
            'format' => 'online',
            'virtual_meeting_url' => 'https://zoom.us/j/9982440911',
            'start_date' => $pastEnd->copy()->subHours(2)->toDateString(),
            'end_date' => $pastEnd->toDateString(),
            'start_time' => $pastEnd->copy()->subHours(2)->format('H:i:s'),
            'end_time' => $pastEnd->format('H:i:s'),
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $passedEvent->id,
            'registration_code' => 'REG-PASSED-ZOOM',
            'qr_pass' => null,
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
            'is_checked_in' => false,
        ]);

        $this->assertTrue($passedEvent->isPassed());

        $response = $this->actingAs($peserta)->get(route('peserta.dashboard', ['tab' => 'tiket']));
        $response->assertStatus(200);
        $response->assertDontSee('Ruang Virtual');
    }

    public function test_virtual_meeting_button_alerts_when_link_not_published_and_event_active(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $upcomingOnline = Event::create([
            'title' => 'Webinar Deep Learning',
            'slug' => 'webinar-deep-learning',
            'category' => 'Webinar',
            'format' => 'online',
            'virtual_meeting_url' => null,
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '23:59:59',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $upcomingOnline->id,
            'registration_code' => 'REG-NO-LINK-01',
            'qr_pass' => null,
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
            'is_checked_in' => false,
        ]);

        $this->assertFalse($upcomingOnline->isPassed());

        $response = $this->actingAs($peserta)->get(route('peserta.dashboard', ['tab' => 'tiket']));
        $response->assertStatus(200);
        $response->assertSee('Ruang Virtual');
        $response->assertSee('alert(\'Tautan Belum Tersedia\')', false);
    }

    public function test_offline_ticket_renders_qr_pass_action_button_and_modal(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $offlineEvent = Event::create([
            'title' => 'Workshop Offline Hardware',
            'slug' => 'workshop-offline-hardware',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab Hardware',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDay()->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '16:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $offlineEvent->id,
            'registration_code' => 'REG-OFF-HDW-01',
            'qr_pass' => 'PASS-OFF-99',
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
            'is_checked_in' => false,
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.dashboard', ['tab' => 'tiket']));
        $response->assertStatus(200);
        $response->assertSee('QR Pass');
        $response->assertSee('modal-qr-pass-viewer');
        $response->assertSee('PASS-OFF-99');
    }

    public function test_organizer_can_create_media_partner_with_logo(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $file = \Illuminate\Http\UploadedFile::fake()->image('partner-logo.png', 200, 200);

        $response = $this->actingAs($panitia)->post(route('organizer.media_partners.store'), [
            'name' => 'Media Informatika Hub',
            'institution' => 'Fakultas Ilmu Komputer',
            'contact_email' => 'partner@hub.id',
            'contact_phone' => '08123456789',
            'logo' => $file,
        ]);

        $response->assertRedirect(route('organizer.media_partners.index'));
        $this->assertDatabaseHas('media_partners', [
            'name' => 'Media Informatika Hub',
            'institution' => 'Fakultas Ilmu Komputer',
        ]);

        $partner = \App\Models\MediaPartner::where('name', 'Media Informatika Hub')->first();
        $this->assertNotNull($partner->logo);
        $rawPath = str_replace('storage/', '', $partner->logo);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($rawPath);
    }

    public function test_organizer_can_create_event_with_media_partners_and_displayed_on_event_show(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $category = \App\Models\Category::first() ?? \App\Models\Category::create(['name' => 'Umum', 'slug' => 'umum']);

        $partner1 = \App\Models\MediaPartner::create([
            'name' => 'Tech News ID',
            'slug' => 'tech-news-id',
            'institution' => 'Media Group',
            'contact_email' => 'tech@news.id',
        ]);
        $partner2 = \App\Models\MediaPartner::create([
            'name' => 'Info IT Nasional',
            'slug' => 'info-it-nasional',
            'institution' => 'Portal Berita IT',
            'contact_email' => 'info@itnasional.id',
        ]);

        $speaker = \App\Models\Speaker::create([
            'name' => 'Dr. Aris Sudarsono',
            'institution' => 'Pusat Riset AI',
            'specialization' => 'Machine Learning',
        ]);

        $payload = [
            'title' => 'Simposium AI Terbuka 2026',
            'category' => $category->name,
            'format' => 'online',
            'location' => 'Zoom Cloud Meetings',
            'description' => 'Simposium nasional terkait penerapan kecerdasan artifisial terkini.',
            'speaker_id' => $speaker->id,
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 100,
            'price' => 0,
            'organizer_type' => 'partner',
            'media_partner_id' => $partner1->id,
            'status' => 'published',
            'media_partner_ids' => [$partner1->id, $partner2->id],
        ];

        $response = $this->actingAs($panitia)->post(route('organizer.event.store'), $payload);
        $response->assertRedirect();

        $event = Event::where('title', 'Simposium AI Terbuka 2026')->first();
        $this->assertNotNull($event);
        $this->assertCount(2, $event->mediaPartners);
        $this->assertEquals('Tech News ID', $event->organizer_name);

        $showResponse = $this->get(route('events.show', $event->slug));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Penyelenggara: Tech News ID');
        $showResponse->assertSee('Media Partner');
        $showResponse->assertSee('Tech News ID');
        $showResponse->assertSee('Info IT Nasional');
    }

    public function test_media_partner_website_url_can_be_stored_and_rendered_as_link(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $response = $this->actingAs($panitia)->post(route('organizer.media_partners.store'), [
            'name' => 'Kanal Riset Tekno',
            'institution' => 'Pusat Riset',
            'contact_email' => 'riset@tekno.id',
            'website_url' => 'https://instagram.com/kanaltekno',
        ]);
        $response->assertRedirect(route('organizer.media_partners.index'));

        $partner = \App\Models\MediaPartner::where('name', 'Kanal Riset Tekno')->first();
        $this->assertNotNull($partner);
        $this->assertEquals('https://instagram.com/kanaltekno', $partner->website_url);

        $event = Event::create([
            'title' => 'Webinar Inovasi AI',
            'slug' => 'webinar-inovasi-ai',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);
        $event->mediaPartners()->attach($partner->id);

        $show = $this->get(route('events.show', $event->slug));
        $show->assertStatus(200);
        $show->assertSee('https://instagram.com/kanaltekno');
    }

    public function test_invoice_and_peserta_dashboard_render_expired_state_after_ten_minutes(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'title' => 'Workshop UI/UX Pro',
            'slug' => 'workshop-uiux-pro',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab ICT 401',
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 30,
            'price' => 75000,
            'status' => 'published',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-EXP-TEST-99',
            'payment_status' => 'pending',
            'attendance_status' => 'unattended',
        ]);
        Registration::where('id', $reg->id)->update(['created_at' => now()->subMinutes(12)]);

        $invoiceResponse = $this->actingAs($peserta)->get(route('payment.invoice', $reg->registration_code));
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee('Batas Waktu Pembayaran Habis');
        $invoiceResponse->assertSee('Daftar Ulang Kegiatan');

        $dashboardResponse = $this->actingAs($peserta)->get(route('peserta.dashboard', ['tab' => 'tiket']));
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Kedaluwarsa');
        $dashboardResponse->assertSee('Daftar Ulang');
    }

    public function test_catalog_renders_penyelenggara_badge_and_excludes_expired_pending_registrations_from_quota(): void
    {
        $event = Event::create([
            'title' => 'Simposium Teknologi Modern',
            'slug' => 'simposium-teknologi-modern',
            'category' => 'Seminar',
            'format' => 'offline',
            'location' => 'Aula Gedung B',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'quota' => 2,
            'price' => 50000,
            'status' => 'published',
            'organizer_type' => 'partner',
            'organizer_name' => 'BEM Fasilkom',
        ]);

        $peserta1 = User::factory()->create(['role' => 'peserta']);
        $regExpired = Registration::create([
            'user_id' => $peserta1->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-EXP-SIMP-01',
            'payment_status' => 'pending',
            'attendance_status' => 'unattended',
        ]);
        Registration::where('id', $regExpired->id)->update(['created_at' => now()->subMinutes(20)]);

        $catalogResponse = $this->get(route('events.index_public'));
        $catalogResponse->assertStatus(200);
        $catalogResponse->assertSee('Penyelenggara: BEM Fasilkom');
        $catalogResponse->assertDontSee('Kuota Penuh');

        $peserta2 = User::factory()->create(['role' => 'peserta']);
        $regPaid = Registration::create([
            'user_id' => $peserta2->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-PAID-SIMP-02',
            'payment_status' => 'paid',
            'attendance_status' => 'unattended',
        ]);

        $catalogResponse2 = $this->get(route('events.index_public'));
        $catalogResponse2->assertStatus(200);
        $catalogResponse2->assertSee('Tersisa 1 slot lagi');
    }

    public function test_expired_registration_ui_and_check_status_api_and_presence_organizer_header(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $partnerEvent = Event::create([
            'title' => 'Konferensi AI Masa Depan',
            'slug' => 'konferensi-ai-masa-depan',
            'category' => 'Konferensi',
            'format' => 'offline',
            'location' => 'Auditorium Utama',
            'start_date' => now()->addDays(4)->toDateString(),
            'end_date' => now()->addDays(4)->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'quota' => 100,
            'price' => 50000,
            'status' => 'published',
            'is_presence_open' => true,
            'organizer_type' => 'partner',
            'organizer_name' => 'GDG Developer Group',
        ]);

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $partnerEvent->id,
            'registration_code' => 'REG-GDG-EXP-01',
            'payment_status' => 'pending',
            'attendance_status' => 'unattended',
        ]);
        Registration::where('id', $reg->id)->update(['created_at' => now()->subMinutes(15)]);

        $dashboardOverview = $this->actingAs($peserta)->get(route('peserta.dashboard'));
        $dashboardOverview->assertStatus(200);
        $dashboardOverview->assertSee('Batas Waktu Habis (Kedaluwarsa)');
        $dashboardOverview->assertSee('Daftar Ulang');

        $showPage = $this->actingAs($peserta)->get(route('events.show', $partnerEvent->slug));
        $showPage->assertStatus(200);
        $showPage->assertSee('Batas Waktu Pembayaran Habis');
        $showPage->assertSee('Daftar Ulang Kegiatan');

        $checkResponse = $this->actingAs($peserta)->postJson(route('payment.check_status', $reg->id));
        $checkResponse->assertStatus(200);
        $checkResponse->assertJson([
            'status' => 'expired',
            'message' => 'Batas waktu pembayaran (10 menit) telah kedaluwarsa. Silakan lakukan pendaftaran ulang.',
        ]);

        $presencePage = $this->actingAs($peserta)->get(route('events.presence', $partnerEvent->slug));
        $presencePage->assertStatus(200);
        $presencePage->assertSee('GDG Developer Group');
        $presencePage->assertDontSee('Laboratorium ICT &bull;');
    }

    public function test_certificate_matching_by_nim_nip_nis_and_label_updates(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $organizer = User::factory()->create(['role' => 'penyelenggara']);
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'nik' => '2210511099',
        ]);

        $event = Event::create([
            'title' => 'Webinar Cloud Computing',
            'slug' => 'webinar-cloud-computing',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        $registerPage = $this->actingAs($peserta)->get(route('events.register.form', $event->slug));
        $registerPage->assertStatus(200);
        $registerPage->assertSee('NIM / NIP / NIS');

        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-CLOUD-01',
            'payment_status' => 'free',
            'attendance_status' => 'unattended',
        ]);

        $profilePage = $this->actingAs($peserta)->get(route('peserta.dashboard', ['tab' => 'profil']));
        $profilePage->assertStatus(200);
        $profilePage->assertSee('NIM / NIP / NIS');

        $certPdf = \Illuminate\Http\UploadedFile::fake()->create('2210511099.pdf', 50, 'application/pdf');

        $uploadResponse = $this->actingAs($organizer)->post(route('organizer.workspace.certificate.batch', $event->id), [
            'certificate_files' => [$certPdf],
        ]);

        $uploadResponse->assertSessionHas('success');
        $this->assertDatabaseHas('certificates', [
            'registration_id' => $reg->id,
            'user_id' => $peserta->id,
            'event_id' => $event->id,
        ]);
    }
}
