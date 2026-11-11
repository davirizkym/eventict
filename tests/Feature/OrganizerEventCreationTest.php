<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Speaker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizerEventCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_penyelenggara_dapat_membuat_kegiatan_baru_dengan_kategori_dan_format_baku(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $speaker = Speaker::create(['name' => 'Dr. Budi Santoso', 'institution' => 'Lab ICT']);

        $response = $this->actingAs($panitia)->post('/penyelenggara/event/create', [
            'title' => 'Workshop Deep Dive Laravel 12',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Laboratorium ICT Lab 4',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'start_time' => '09:00',
            'end_time' => '15:00',
            'quota' => 60,
            'price' => 0,
            'description' => 'Pelatihan intensif fitur terbaru Laravel 12 dan PHP 8.4.',
            'speaker_ids' => [$speaker->id],
            'speaker_roles' => ['Pemateri'],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('events', [
            'title' => 'Workshop Deep Dive Laravel 12',
            'category' => 'Workshop',
            'format' => 'offline',
        ]);
    }

    public function test_pembuatan_kegiatan_gagal_jika_pengisi_acara_tidak_dipilih(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);

        $response = $this->actingAs($panitia)->post('/penyelenggara/event/create', [
            'title' => 'Workshop Tanpa Pembicara',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Laboratorium ICT',
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'start_time' => '09:00',
            'end_time' => '12:00',
            'quota' => 50,
            'price' => 0,
            'description' => 'Testing tanpa pembicara.',
        ]);

        $response->assertSessionHasErrors(['speaker_ids']);
    }

    public function test_penyelenggara_dapat_memilih_banyak_pengisi_acara_dengan_peran_otomatis_dinomori(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);

        $speakerA = Speaker::create(['name' => 'Dr. Budi Santoso', 'institution' => 'Lab ICT']);
        $speakerB = Speaker::create(['name' => 'Ir. Siti Aminah', 'institution' => 'Google']);
        $speakerC = Speaker::create(['name' => 'Ahmad Fauzi', 'institution' => 'Komunitas Web']);

        $response = $this->actingAs($panitia)->post('/penyelenggara/event/create', [
            'title' => 'Seminar AI & Quantum Computing',
            'category' => 'Seminar',
            'format' => 'online',
            'location' => 'Platform Zoom',
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(10)->toDateString(),
            'start_time' => '08:30',
            'end_time' => '12:30',
            'quota' => 200,
            'price' => 50000,
            'description' => 'Eksplorasi tren teknologi kuantum dan AI terapan.',
            'speaker_ids' => [$speakerA->id, $speakerB->id, $speakerC->id],
            'speaker_roles' => ['Pemateri', 'Pemateri', 'MC'],
            'speaker_topics' => ['Konsep Dasar Quantum', 'Algoritma AI Terkini', 'Pemandu Acara'],
        ]);

        $response->assertRedirect();
        $event = Event::where('title', 'Seminar AI & Quantum Computing')->first();
        $this->assertNotNull($event);

        // Verifikasi ketiga pengisi acara terpasang di pivot
        $this->assertEquals(3, $event->speakers()->count());

        // Verifikasi bahwa Pemateri pertama menjadi "Pemateri 1", kedua "Pemateri 2", dan MC menjadi "MC"
        $speakerAPivot = $event->speakers()->where('speakers.id', $speakerA->id)->first()->pivot;
        $speakerBPivot = $event->speakers()->where('speakers.id', $speakerB->id)->first()->pivot;
        $speakerCPivot = $event->speakers()->where('speakers.id', $speakerC->id)->first()->pivot;

        $this->assertEquals('Pemateri 1', $speakerAPivot->role);
        $this->assertEquals('Pemateri 2', $speakerBPivot->role);
        $this->assertEquals('MC', $speakerCPivot->role);
    }

    public function test_pembuatan_kegiatan_gagal_jika_satu_pengisi_acara_dipilih_lebih_dari_satu_kali(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);

        $speakerA = Speaker::create(['name' => 'Dr. Budi Santoso', 'institution' => 'Lab ICT']);

        $response = $this->actingAs($panitia)->post('/penyelenggara/event/create', [
            'title' => 'Workshop Duplikat Narasumber',
            'category' => 'Workshop',
            'format' => 'offline',
            'location' => 'Lab ICT',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'start_time' => '09:00',
            'end_time' => '12:00',
            'quota' => 30,
            'price' => 0,
            'description' => 'Test satu orang dengan dua peran.',
            'speaker_ids' => [$speakerA->id, $speakerA->id],
            'speaker_roles' => ['Pemateri', 'Moderator'],
        ]);

        $response->assertSessionHasErrors();
        $this->assertDatabaseMissing('events', ['title' => 'Workshop Duplikat Narasumber']);
    }
}
