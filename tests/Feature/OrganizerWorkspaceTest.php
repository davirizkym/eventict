<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrganizerWorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_workspace_loads_correctly_and_calculates_revenue_without_error(): void
    {
        $panitia = User::factory()->create([
            'role' => 'penyelenggara',
            'email' => 'panitia@eventict.id',
        ]);

        $event = Event::create([
            'title' => 'Workshop UI/UX Design System',
            'slug' => 'workshop-ui-ux-design-system',
            'category' => 'Desain',
            'format' => 'offline',
            'location' => 'Gedung Serbaguna',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(3),
            'start_time' => '09:00:00',
            'end_time' => '15:00:00',
            'quota' => 50,
            'price' => 100000,
            'status' => 'published',
            'skp_points' => 2,
        ]);

        $peserta = User::factory()->create(['role' => 'peserta']);

        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-2026-TEST',
            'qr_pass' => 'PASS-TEST-1234',
            'payment_status' => 'paid',
            'attendance_status' => 'attended',
            'amount_paid' => 100000,
        ]);

        $response = $this->actingAs($panitia)->get("/penyelenggara/event/{$event->id}");

        $response->assertStatus(200);
        $response->assertSee('Workshop UI/UX Design System');
        $response->assertSee('Rp 100.000');
    }

    public function test_organizer_can_assign_multiple_speakers_with_roles_in_workspace(): void
    {
        $panitia = User::factory()->create([
            'role' => 'penyelenggara',
            'email' => 'panitia2@eventict.id',
        ]);

        $event = Event::create([
            'title' => 'Webinar AI Cloud Native',
            'slug' => 'webinar-ai-cloud-native',
            'category' => 'Webinar',
            'format' => 'online',
            'location' => 'Zoom Meeting',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(5),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
        ]);

        $spk1 = \App\Models\Speaker::create([
            'name' => 'Dr. Razin Qeenan',
            'email' => 'razin@ict.ac.id',
            'institution' => 'Lab ICT',
        ]);

        $spk2 = \App\Models\Speaker::create([
            'name' => 'Siti Aisyah, S.Kom',
            'email' => 'siti@ict.ac.id',
            'institution' => 'Lab ICT',
        ]);

        // Assign Pemateri 1
        $res1 = $this->actingAs($panitia)->post(route('organizer.event.speaker.assign', ['event' => $event->id]), [
            'speaker_id' => $spk1->id,
            'role' => 'Pemateri',
        ]);
        $res1->assertRedirect();

        // Assign Pemateri 2 (auto indexed to Pemateri 2)
        $res2 = $this->actingAs($panitia)->post(route('organizer.event.speaker.assign', ['event' => $event->id]), [
            'speaker_id' => $spk2->id,
            'role' => 'Pemateri',
        ]);
        $res2->assertRedirect();

        $this->assertDatabaseHas('event_speaker', [
            'event_id' => $event->id,
            'speaker_id' => $spk1->id,
            'role' => 'Pemateri',
        ]);

        $this->assertDatabaseHas('event_speaker', [
            'event_id' => $event->id,
            'speaker_id' => $spk2->id,
            'role' => 'Pemateri 2',
        ]);

        $page = $this->actingAs($panitia)->get("/penyelenggara/event/{$event->id}?tab=narasumber");
        $page->assertStatus(200);
        $page->assertSee('Dr. Razin Qeenan');
        $page->assertSee('Pemateri');
        $page->assertSee('Siti Aisyah, S.Kom');
        $page->assertSee('Pemateri 2');
    }

    public function test_organizer_cannot_assign_same_speaker_twice_in_same_event(): void
    {
        $panitia = User::factory()->create([
            'role' => 'penyelenggara',
            'email' => 'panitia3@eventict.id',
        ]);

        $event = Event::create([
            'title' => 'Workshop Ethical Hacking',
            'slug' => 'workshop-ethical-hacking',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab ICT',
            'start_date' => now()->addDays(4),
            'end_date' => now()->addDays(4),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 40,
            'price' => 0,
            'status' => 'published',
        ]);

        $spk = \App\Models\Speaker::create([
            'name' => 'Adhitya Pratama',
            'email' => 'adhitya@ict.ac.id',
            'institution' => 'Lab ICT',
        ]);

        // Assign pertama kali berhasil
        $res1 = $this->actingAs($panitia)->post(route('organizer.event.speaker.assign', ['event' => $event->id]), [
            'speaker_id' => $spk->id,
            'role' => 'Pemateri',
        ]);
        $res1->assertRedirect();
        $this->assertEquals(1, $event->speakers()->count());

        // Assign kedua kali dengan orang yang sama harus gagal
        $res2 = $this->actingAs($panitia)->post(route('organizer.event.speaker.assign', ['event' => $event->id]), [
            'speaker_id' => $spk->id,
            'role' => 'Moderator',
        ]);
        $res2->assertSessionHasErrors(['speaker_id']);
        $this->assertEquals(1, $event->speakers()->count());
    }

    public function test_organizer_can_view_stage_projector_screen(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = Event::create([
            'title' => 'Simposium AI Healthcare',
            'slug' => 'simposium-ai-healthcare',
            'category' => 'Simposium',
            'format' => 'offline',
            'location' => 'Auditorium ICT',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
            'is_presence_open' => true,
        ]);

        $response = $this->actingAs($panitia)->get(route('organizer.workspace.stage', ['event' => $event->id]));

        $response->assertStatus(200);
        $response->assertSee('Simposium AI Healthcare');
        $response->assertSee('create-qr-code');
    }

    public function test_stage_screen_is_inaccessible_when_presence_gate_is_closed(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = Event::create([
            'title' => 'Simposium AI Healthcare Closed',
            'slug' => 'simposium-ai-healthcare-closed',
            'category' => 'Simposium',
            'format' => 'offline',
            'location' => 'Auditorium ICT',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
            'is_presence_open' => false,
        ]);

        $response = $this->actingAs($panitia)->get(route('organizer.workspace.stage', ['event' => $event->id]));

        $response->assertRedirect(route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta']));
        $response->assertSessionHas('warning', 'Buka presensi sesi terlebih dahulu sebelum menampilkan QR presensi.');
    }

    public function test_stage_status_endpoint_returns_realtime_metrics(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = Event::create([
            'title' => 'Simposium Big Data Klinis',
            'slug' => 'simposium-big-data-klinis',
            'category' => 'Simposium',
            'format' => 'online',
            'location' => 'Zoom Live Stream',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
            'is_presence_open' => false,
        ]);

        $peserta = User::factory()->create(['role' => 'peserta', 'name' => 'dr. Budi Santoso']);
        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-STAGE-001',
            'qr_pass' => 'PASS-STAGE-001',
            'payment_status' => 'free',
            'attendance_status' => 'attended',
        ]);

        $response = $this->actingAs($panitia)->getJson(route('organizer.workspace.stage_status', ['event' => $event->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'is_presence_open' => false,
            'attended_count' => 1,
            'total_registrations' => 1,
            'percentage' => 100,
        ]);
        $response->assertJsonFragment([
            'name' => 'dr. Budi Santoso',
        ]);
    }

    public function test_organizer_can_toggle_presence_gate_via_json(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = Event::create([
            'title' => 'Workshop Telemedisin',
            'slug' => 'workshop-telemedisin',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Ruang Lab 2',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1),
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'quota' => 30,
            'price' => 0,
            'status' => 'published',
            'is_presence_open' => false,
        ]);

        $response = $this->actingAs($panitia)->postJson(route('organizer.workspace.presence.toggle', ['event' => $event->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_presence_open' => true,
        ]);

        $this->assertTrue((bool) $event->fresh()->is_presence_open);
    }

    public function test_organizer_can_view_certificate_tab_with_metrics_and_participant_list(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = Event::create([
            'title' => 'Simposium Rekam Medis Elektronik',
            'slug' => 'simposium-rekam-medis-elektronik',
            'category' => 'Seminar',
            'format' => 'offline',
            'location' => 'Aula Utama',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        $peserta = User::factory()->create(['role' => 'peserta', 'name' => 'dr. Siti Rahma']);
        Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-CERT-001',
            'qr_pass' => 'PASS-CERT-001',
            'payment_status' => 'free',
            'attendance_status' => 'attended',
        ]);

        $response = $this->actingAs($panitia)->get(route('organizer.workspace', ['event' => $event->id, 'tab' => 'sertifikat']));

        $response->assertStatus(200);
        $response->assertSee('Total Pendaftar');
        $response->assertSee('Hadir (Berhak Sertifikat)');
        $response->assertSee('Sertifikat Terbit');
        $response->assertSee('Belum Diterbitkan');
        $response->assertSee('dr. Siti Rahma');
        $response->assertSee('REG-CERT-001');
        $response->assertSee('Unggah Satuan');
    }

    public function test_organizer_can_upload_single_certificate_and_delete_it(): void
    {
        Storage::fake('public');

        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = Event::create([
            'title' => 'Webinar Telehealth',
            'slug' => 'webinar-telehealth',
            'category' => 'Webinar',
            'format' => 'online',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        $peserta = User::factory()->create(['role' => 'peserta', 'name' => 'dr. Ahmad']);
        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-AHMAD-01',
            'qr_pass' => 'PASS-AHMAD-01',
            'payment_status' => 'free',
            'attendance_status' => 'attended',
        ]);

        $file = UploadedFile::fake()->create('sertifikat.pdf', 200, 'application/pdf');

        $uploadResponse = $this->actingAs($panitia)->post(route('organizer.certificate.single', $reg->id), [
            'certificate_file' => $file,
            'certificate_number' => 'ICT-CERT/2026/99999',
        ]);

        $uploadResponse->assertSessionHas('success');

        $this->assertDatabaseHas('certificates', [
            'registration_id' => $reg->id,
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'certificate_number' => 'ICT-CERT/2026/99999',
        ]);

        $cert = Certificate::where('registration_id', $reg->id)->first();
        $this->assertNotNull($cert);
        $this->assertNotNull($cert->verify_hash);
        $this->assertNotNull($cert->download_url);

        $storedPath = str_replace('storage/', '', $cert->download_url);
        Storage::disk('public')->assertExists($storedPath);

        $deleteResponse = $this->actingAs($panitia)->delete(route('organizer.certificate.delete', $reg->id));
        $deleteResponse->assertSessionHas('success');

        $this->assertDatabaseMissing('certificates', [
            'registration_id' => $reg->id,
        ]);
        Storage::disk('public')->assertMissing($storedPath);
    }

    public function test_organizer_can_batch_upload_certificates_in_workspace(): void
    {
        Storage::fake('public');

        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = Event::create([
            'title' => 'Pelatihan AI Medis',
            'slug' => 'pelatihan-ai-medis',
            'category' => 'Workshop',
            'format' => 'offline',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
        ]);

        $peserta = User::factory()->create(['role' => 'peserta']);
        $reg = Registration::create([
            'user_id' => $peserta->id,
            'event_id' => $event->id,
            'registration_code' => 'REG-BATCH-001',
            'qr_pass' => 'PASS-BATCH-001',
            'payment_status' => 'free',
            'attendance_status' => 'attended',
        ]);

        $file = UploadedFile::fake()->create('REG-BATCH-001.pdf', 300, 'application/pdf');

        $response = $this->actingAs($panitia)->post(route('organizer.workspace.certificate.batch', $event->id), [
            'certificate_files' => [$file],
        ]);

        $response->assertRedirect(route('organizer.workspace', ['event' => $event->id, 'tab' => 'sertifikat']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('certificates', [
            'registration_id' => $reg->id,
            'user_id' => $peserta->id,
            'event_id' => $event->id,
        ]);

        $cert = Certificate::where('registration_id', $reg->id)->first();
        $this->assertNotNull($cert);
        $this->assertNotNull($cert->verify_hash);
        $this->assertNotNull($cert->download_url);
    }
}
