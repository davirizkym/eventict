<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\MediaPartner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class MediaPartnerPromoEventTest extends TestCase
{
    use RefreshDatabase;

    private function createEvent(array $overrides = []): Event
    {
        $title = $overrides['title'] ?? 'Contoh Kegiatan ' . Str::random(5);
        $defaults = [
            'title' => $title,
            'slug' => Str::slug($title),
            'category' => 'Workshop',
            'type' => 'Workshop',
            'format' => 'online',
            'location' => 'Zoom Cloud Meeting',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 100,
            'price' => 0,
            'status' => 'published',
            'organizer_type' => 'internal',
            'organizer_name' => 'Laboratorium ICT',
            'description' => 'Deskripsi kegiatan workshop.',
            'skp_points' => 0,
        ];

        return Event::create(array_merge($defaults, $overrides));
    }

    public function test_penyelenggara_dapat_membuat_acara_media_partner_promosi_tanpa_pengisi_acara(): void
    {
        Storage::fake('public');

        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $mediaPartner = MediaPartner::create([
            'name' => 'Himpunan Mahasiswa Informatika',
            'slug' => 'hima-if',
            'type' => 'Himpunan Kampus',
            'email' => 'hima@campus.ac.id',
            'status' => 'active',
        ]);

        $poster = UploadedFile::fake()->image('poster_acara.jpg', 600, 800);

        $response = $this->actingAs($panitia)->post('/penyelenggara/event/create', [
            'title' => 'Webinar Nasional Cyber Security HIMA',
            'type' => 'Webinar',
            'format' => 'online',
            'location' => 'Zoom Meeting',
            'start_date' => now()->addDays(7)->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
            'start_time' => '13:00',
            'end_time' => '16:00',
            'quota' => 200,
            'price' => 0,
            'description' => 'Webinar kolaborasi promosi bersama HIMA Informatika.',
            'organizer_type' => 'partner',
            'media_partner_id' => $mediaPartner->id,
            'registration_url' => 'https://forms.gle/samplePromoRegister123',
            'poster' => $poster,
        ]);

        $response->assertRedirect();

        $event = Event::where('title', 'Webinar Nasional Cyber Security HIMA')->first();
        $this->assertNotNull($event);
        $this->assertEquals('partner', $event->organizer_type);
        $this->assertEquals('Himpunan Mahasiswa Informatika', $event->organizer_name);
        $this->assertEquals('https://forms.gle/samplePromoRegister123', $event->registration_url);
        $this->assertNotNull($event->banner_url);
        $this->assertTrue($event->isExternal());

        // File poster tersimpan di storage public
        $storedPosterPath = str_replace('/storage/', '', $event->banner_url);
        Storage::disk('public')->assertExists($storedPosterPath);
    }

    public function test_penyelenggara_dapat_memperbarui_poster_dan_link_pendaftaran_pada_pengaturan_acara(): void
    {
        Storage::fake('public');

        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = $this->createEvent([
            'title' => 'Bootcamp Flutter 2026',
            'organizer_type' => 'partner',
            'registration_url' => 'https://old-form.com',
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(10)->toDateString(),
            'start_time' => '09:00',
            'end_time' => '12:00',
        ]);

        $newPoster = UploadedFile::fake()->image('new_poster.png');

        $response = $this->actingAs($panitia)->put("/penyelenggara/event/{$event->id}", [
            'title' => 'Bootcamp Flutter 2026 Updated',
            'type' => 'Workshop',
            'format' => 'online',
            'location' => 'Google Meet',
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(10)->toDateString(),
            'start_time' => '09:00',
            'end_time' => '12:00',
            'quota' => 150,
            'price' => 0,
            'description' => 'Deskripsi update bootcamp flutter.',
            'status' => 'published',
            'organizer_type' => 'partner',
            'registration_url' => 'https://forms.gle/newFlutterRegistration',
            'poster' => $newPoster,
        ]);

        $response->assertRedirect();

        $event->refresh();
        $this->assertEquals('https://forms.gle/newFlutterRegistration', $event->registration_url);
        $this->assertNotNull($event->banner_url);
    }

    public function test_halaman_detail_acara_media_partner_menampilkan_tombol_daftar_acara_langsung_ke_link_mitra_untuk_tamu(): void
    {
        $event = $this->createEvent([
            'title' => 'Seminar Tech AI 2026',
            'organizer_type' => 'partner',
            'organizer_name' => 'Komunitas Data Science',
            'registration_url' => 'https://forms.gle/partnerRegistrationForm',
            'banner_url' => '/storage/posters/sample-poster.jpg',
            'status' => 'published',
        ]);

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);

        // Menampilkan tombol "Daftar Acara" dengan target registration_url
        $response->assertSee('Daftar Acara');
        $response->assertSee('https://forms.gle/partnerRegistrationForm');

        // Menampilkan poster kegiatan
        $response->assertSee('Poster Kegiatan');
        $response->assertSee('/storage/posters/sample-poster.jpg');

        // Memastikan tidak ada ajakan login / registrasi akun internal peserta
        $response->assertDontSee('Masuk untuk Mendaftar Sesi');
        $response->assertDontSee('Belum punya akun?');
    }

    public function test_halaman_detail_acara_media_partner_menampilkan_tombol_daftar_acara_ke_link_mitra_untuk_user_login(): void
    {
        $user = User::factory()->create(['role' => 'peserta']);

        $event = $this->createEvent([
            'title' => 'Seminar Cloud Security Mitra',
            'organizer_type' => 'partner',
            'organizer_name' => 'Mitra Tech Partner',
            'registration_url' => 'https://partner-portal.com/register/cloud',
            'status' => 'published',
        ]);

        $response = $this->actingAs($user)->get(route('events.show', $event->slug));

        $response->assertStatus(200);
        $response->assertSee('Daftar Acara');
        $response->assertSee('https://partner-portal.com/register/cloud');
        $response->assertDontSee('Daftar Sesi Kegiatan Ini');
    }

    public function test_rute_pendaftaran_langsung_redirect_ke_registration_url_jika_acara_eksternal(): void
    {
        $user = User::factory()->create(['role' => 'peserta']);

        $event = $this->createEvent([
            'title' => 'Hackathon Inovasi Kampus',
            'organizer_type' => 'partner',
            'registration_url' => 'https://forms.gle/hackathonRegistrationLink',
            'status' => 'published',
        ]);

        $responseGet = $this->actingAs($user)->get(route('events.register.form', $event->slug));
        $responseGet->assertRedirect('https://forms.gle/hackathonRegistrationLink');

        $responsePost = $this->actingAs($user)->post(route('events.register', $event->slug));
        $responsePost->assertRedirect('https://forms.gle/hackathonRegistrationLink');
    }
}
