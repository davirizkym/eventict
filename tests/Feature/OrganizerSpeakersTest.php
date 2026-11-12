<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Speaker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrganizerSpeakersTest extends TestCase
{
    use RefreshDatabase;

    private function createPanitia(): User
    {
        return User::factory()->create([
            'role' => 'penyelenggara',
            'name' => 'Panitia Pelaksana',
            'email' => 'panitia@eventict.id',
        ]);
    }

    public function test_speakers_index_table_loads_with_pagination_and_columns(): void
    {
        $panitia = $this->createPanitia();

        $speaker = Speaker::create([
            'name' => 'Dr. Ir. Budi Santoso, M.Kom.',
            'title_degree' => 'M.Kom.',
            'institution' => 'Universitas Budi Luhur',
            'profession' => 'Dosen Teknik Informatika',
            'email' => 'budi.santoso@budiluhur.ac.id',
            'phone' => '081234567890',
            'city' => 'Jakarta',
            'bio' => 'Dosen senior dengan keahlian arsitektur software dan sistem terdistribusi.',
        ]);

        $response = $this->actingAs($panitia)->get('/penyelenggara/narasumber');

        $response->assertStatus(200);
        $response->assertSee('Tabel Daftar Pengisi Acara');
        $response->assertSee('Tambah Pengisi Acara');
        $response->assertSee('Cari nama pengisi acara atau asal instansi...');
        $response->assertSee('Dr. Ir. Budi Santoso, M.Kom.');
        $response->assertSee('Universitas Budi Luhur');
        $response->assertSee('Dosen Teknik Informatika');
        $response->assertSee('budi.santoso@budiluhur.ac.id');
        $response->assertSee('081234567890');
        $response->assertSee(route('organizer.speakers.show', $speaker->id));
    }

    public function test_store_pengisi_acara_with_validation_and_photo_upload(): void
    {
        Storage::fake('public');
        $panitia = $this->createPanitia();

        $fakePhoto = UploadedFile::fake()->image('speaker_budi.jpg', 400, 400);

        $response = $this->actingAs($panitia)->post('/penyelenggara/narasumber', [
            'name' => 'Dr. Ir. Budi Santoso, M.Kom.',
            'institution' => 'PT Telkom Indonesia',
            'profession' => 'Cloud Architect',
            'title_degree' => 'M.Kom.',
            'email' => 'budi.santoso@telkom.co.id',
            'phone' => '081298765432',
            'city' => 'Bandung',
            'bio' => 'Cloud Architect berpengalaman lebih dari 10 tahun memimpin transformasi cloud skala nasional.',
            'photo' => $fakePhoto,
        ]);

        $response->assertRedirect('/penyelenggara/narasumber');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('speakers', [
            'name' => 'Dr. Ir. Budi Santoso, M.Kom.',
            'institution' => 'PT Telkom Indonesia',
            'profession' => 'Cloud Architect',
            'email' => 'budi.santoso@telkom.co.id',
            'phone' => '081298765432',
        ]);

        $speaker = Speaker::where('email', 'budi.santoso@telkom.co.id')->first();
        $this->assertNotNull($speaker->photo_url);
    }

    public function test_show_detail_page_displays_profile_and_event_participation_history_with_roles(): void
    {
        $panitia = $this->createPanitia();

        $speaker = Speaker::create([
            'name' => 'Indah Kusuma, S.Kom., M.T.',
            'title_degree' => 'M.T.',
            'institution' => 'Lab ICT',
            'profession' => 'Cyber Security Specialist',
            'email' => 'indah.kusuma@eventict.id',
            'phone' => '081398761234',
            'bio' => 'Pakar ethical hacking dan penilai kepatuhan keamanan informasi.',
        ]);

        $event1 = Event::create([
            'title' => 'Seminar Cyber Security & Threat Intelligence',
            'slug' => 'seminar-cyber-security',
            'category' => 'Security',
            'format' => 'online',
            'location' => 'Zoom Meeting',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(3),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
        ]);

        $event2 = Event::create([
            'title' => 'Workshop Hands-On Penetration Testing',
            'slug' => 'workshop-penetration-testing',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab Riset 2',
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(7),
            'start_time' => '13:00:00',
            'end_time' => '16:00:00',
            'quota' => 40,
            'price' => 50000,
            'status' => 'published',
        ]);

        // Attach events with explicit roles: Pemateri & Moderator
        $speaker->events()->attach($event1->id, [
            'role' => 'Pemateri',
            'topic' => 'Mitigasi Kerentanan OWASP Top 10',
            'session_time' => '09:30 - 11:30 WIB',
        ]);

        $speaker->events()->attach($event2->id, [
            'role' => 'Moderator',
            'topic' => 'Moderasi Sesi Praktik Lab Penetrasi',
            'session_time' => '13:00 - 16:00 WIB',
        ]);

        // Access the Detail Page
        $response = $this->actingAs($panitia)->get("/penyelenggara/narasumber/{$speaker->id}");

        $response->assertStatus(200);
        $response->assertSee('Indah Kusuma, S.Kom., M.T.');
        $response->assertSee('Cyber Security Specialist');
        $response->assertSee('Lab ICT');
        $response->assertSee('Tabel Riwayat Partisipasi Acara');
        $response->assertSee('Seminar Cyber Security & Threat Intelligence');
        $response->assertSee('Berperan sebagai Pemateri');
        $response->assertSee('Workshop Hands-On Penetration Testing');
        $response->assertSee('Berperan sebagai Moderator');
    }

    public function test_assign_events_from_detail_page(): void
    {
        $panitia = $this->createPanitia();

        $speaker = Speaker::create([
            'name' => 'Fajar Pratama, M.Kom',
            'institution' => 'Universitas Indonesia',
            'profession' => 'AI Researcher',
        ]);

        $event = Event::create([
            'title' => 'Simposium AI & Robotics 2026',
            'slug' => 'simposium-ai-robotics-2026',
            'category' => 'AI',
            'format' => 'offline',
            'location' => 'Auditorium Lab ICT',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(10),
            'start_time' => '08:30:00',
            'end_time' => '15:00:00',
            'quota' => 200,
            'price' => 75000,
            'status' => 'published',
        ]);

        $response = $this->actingAs($panitia)->post("/penyelenggara/narasumber/{$speaker->id}/penempatan", [
            'event_ids' => [$event->id],
            'roles' => [$event->id => 'Keynote Speaker'],
            'topics' => [$event->id => 'The Future of Autonomous Agents'],
            'session_times' => [$event->id => '09:00 - 10:30 WIB'],
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('event_speaker', [
            'speaker_id' => $speaker->id,
            'event_id' => $event->id,
            'role' => 'Keynote Speaker',
            'topic' => 'The Future of Autonomous Agents',
        ]);
    }
}
