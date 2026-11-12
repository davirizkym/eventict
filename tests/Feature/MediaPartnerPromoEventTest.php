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

        // Biaya pendaftaran (price) tidak dikirimkan karena field disembunyikan untuk media partner
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
        $this->assertEquals(0, $event->price);
        $this->assertEquals('Himpunan Mahasiswa Informatika', $event->organizer_name);
        $this->assertEquals('https://forms.gle/samplePromoRegister123', $event->registration_url);
        $this->assertNotNull($event->banner_url);
        $this->assertTrue($event->isExternal());

        // File poster tersimpan di storage public
        $storedPosterPath = str_replace('/storage/', '', $event->banner_url);
        Storage::disk('public')->assertExists($storedPosterPath);
    }

    public function test_penyelenggara_dapat_membuat_acara_media_partner_tanpa_input_quota_dan_price(): void
    {
        Storage::fake('public');

        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $mediaPartner = MediaPartner::create([
            'name' => 'BEM Fakultas Teknologi Informasi',
            'slug' => 'bem-fti',
            'type' => 'BEM Kampus',
            'email' => 'bem@campus.ac.id',
            'status' => 'active',
        ]);

        // Tidak mengirimkan 'quota' dan 'price' karena input disabled pada antarmuka
        $response = $this->actingAs($panitia)->post('/penyelenggara/event/create', [
            'title' => 'Webinar AI BEM FTI',
            'type' => 'Webinar',
            'format' => 'online',
            'location' => 'Zoom Meeting',
            'start_date' => now()->addDays(7)->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
            'start_time' => '13:00',
            'end_time' => '16:00',
            'description' => 'Webinar kolaborasi promosi bersama BEM FTI.',
            'organizer_type' => 'partner',
            'media_partner_id' => $mediaPartner->id,
            'registration_url' => 'https://forms.gle/sampleBEM123',
        ]);

        $response->assertRedirect();

        $event = Event::where('title', 'Webinar AI BEM FTI')->first();
        $this->assertNotNull($event);
        $this->assertEquals(0, $event->quota);
        $this->assertEquals(0, $event->price);
        $this->assertEquals('partner', $event->organizer_type);
        $this->assertEquals('BEM Fakultas Teknologi Informasi', $event->organizer_name);
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
        $response->assertDontSee('Biaya Investasi:');
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

    public function test_workspace_media_partner_hanya_menampilkan_pengaturan_acara_dan_tidak_menampilkan_peserta_sertifikat_pengisi_acara(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = $this->createEvent([
            'title' => 'Festival Teknologi Kampus',
            'organizer_type' => 'partner',
            'organizer_name' => 'BEM Fakultas Teknik',
            'registration_url' => 'https://forms.gle/bemFestivalTeknologi',
            'status' => 'published',
        ]);

        // Mengakses workspace default langsung menampilkan tab pengaturan
        $responseDefault = $this->actingAs($panitia)->get("/penyelenggara/event/{$event->id}");
        $responseDefault->assertStatus(200);
        $responseDefault->assertSee('Pengaturan Acara');

        // Mengakses tab peserta diarahkan kembali ke tab=pengaturan
        $responsePeserta = $this->actingAs($panitia)->get("/penyelenggara/event/{$event->id}?tab=peserta");
        $responsePeserta->assertRedirect("/penyelenggara/event/{$event->id}?tab=pengaturan");

        // Mengakses tab sertifikat diarahkan kembali ke tab=pengaturan
        $responseSertifikat = $this->actingAs($panitia)->get("/penyelenggara/event/{$event->id}?tab=sertifikat");
        $responseSertifikat->assertRedirect("/penyelenggara/event/{$event->id}?tab=pengaturan");

        // Mengakses tab narasumber diarahkan kembali ke tab=pengaturan
        $responseNarasumber = $this->actingAs($panitia)->get("/penyelenggara/event/{$event->id}?tab=narasumber");
        $responseNarasumber->assertRedirect("/penyelenggara/event/{$event->id}?tab=pengaturan");

        // Mengakses tab pengaturan menampilkan form pengaturan dan tidak ada tab lainnya
        $responsePengaturan = $this->actingAs($panitia)->get("/penyelenggara/event/{$event->id}?tab=pengaturan");
        $responsePengaturan->assertStatus(200);
        $responsePengaturan->assertSee('Pengaturan Acara');
        $responsePengaturan->assertSee('Informasi Media Partner');
        $responsePengaturan->assertSee('https://forms.gle/bemFestivalTeknologi');

        // Pastikan tidak ada modal pemindaian QR pass, narasumber, atau sertifikat
        $responsePengaturan->assertDontSee('Pindai QR Pass Peserta');
        $responsePengaturan->assertDontSee('Tugaskan Pengisi Acara');
        $responsePengaturan->assertDontSee('Unggah Sertifikat Peserta');
    }

    public function test_hub_penyelenggara_menampilkan_badge_promosi_mitra_dan_tautan_kelola_acara(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = $this->createEvent([
            'title' => 'Workshop UI/UX Bersama Mitra',
            'organizer_type' => 'partner',
            'organizer_name' => 'Komunitas Desain Grafis',
            'registration_url' => 'https://forms.gle/desainWorkshop',
            'status' => 'published',
        ]);

        $response = $this->actingAs($panitia)->get(route('organizer.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Workshop UI/UX Bersama Mitra');
        $response->assertSee('Media Partner');
        $response->assertSee('Kelola Acara');
        $response->assertSee("/penyelenggara/event/{$event->id}?tab=pengaturan");
    }

    public function test_penyelenggara_dapat_menghapus_kegiatan_melalui_pengaturan_acara(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $event = $this->createEvent([
            'title' => 'Webinar Yang Dibatalkan',
            'organizer_type' => 'partner',
            'organizer_name' => 'Mitra Batal',
        ]);

        // Periksa bahwa tombol hapus acara tampil di tab pengaturan
        $responseWorkspace = $this->actingAs($panitia)->get(route('organizer.workspace', ['event' => $event->id, 'tab' => 'pengaturan']));
        $responseWorkspace->assertStatus(200);
        $responseWorkspace->assertSee('Hapus Acara');
        $responseWorkspace->assertSee(route('organizer.event.destroy', $event->id));

        // Eksekusi penghapusan acara
        $responseDelete = $this->actingAs($panitia)->delete(route('organizer.event.destroy', $event->id));
        $responseDelete->assertRedirect(route('organizer.dashboard'));
        $responseDelete->assertSessionHas('success');

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_halaman_peserta_menampilkan_badge_dan_tombol_jelas_untuk_acara_media_partner(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);
        $event = $this->createEvent([
            'title' => 'Bootcamp AI & Robotics Indonesia',
            'organizer_type' => 'partner',
            'organizer_name' => 'Komunitas Robotika Nasional',
            'registration_url' => 'https://forms.gle/roboticsRegistration',
            'status' => 'published',
        ]);

        $response = $this->actingAs($peserta)->get('/peserta?tab=kegiatan');
        $response->assertStatus(200);
        $response->assertSee('Bootcamp AI & Robotics Indonesia');
        $response->assertSee('Media Partner');
        $response->assertSee('Penyelenggara: Komunitas Robotika Nasional');
        $response->assertSee('Daftar Acara');
    }

    public function test_penyelenggara_dapat_membuat_acara_media_partner_tanpa_kuota_dan_tersimpan_nol(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $mediaPartner = MediaPartner::create([
            'name' => 'Komunitas AI Indonesia',
            'slug' => 'komunitas-ai-id',
            'type' => 'Komunitas',
            'status' => 'active',
        ]);

        // Kirim pembuatan acara tanpa kuota
        $response = $this->actingAs($panitia)->post('/penyelenggara/event/create', [
            'title' => 'AI Conference Partner 2026',
            'type' => 'Seminar',
            'format' => 'online',
            'location' => 'Zoom',
            'start_date' => now()->addDays(4)->toDateString(),
            'end_date' => now()->addDays(4)->toDateString(),
            'start_time' => '10:00',
            'end_time' => '13:00',
            'description' => 'Konferensi AI bersama komunitas.',
            'organizer_type' => 'partner',
            'media_partner_id' => $mediaPartner->id,
            'registration_url' => 'https://forms.gle/aiConferenceLink',
        ]);

        $response->assertRedirect();

        $event = Event::where('title', 'AI Conference Partner 2026')->first();
        $this->assertNotNull($event);
        $this->assertEquals(0, $event->quota);
        $this->assertEquals('partner', $event->organizer_type);

        // Di katalog publik, acara media partner tidak menampilkan kuota atau kata "Penuh"
        $catalogResponse = $this->get(route('events.index_public'));
        $catalogResponse->assertStatus(200);
        $catalogResponse->assertSee('AI Conference Partner 2026');
        $catalogResponse->assertSee('Media Partner');
    }

    public function test_buat_kegiatan_gagal_jika_tanggal_mulai_di_hari_yang_sama_atau_sebelumnya(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $mediaPartner = MediaPartner::create([
            'name' => 'Mitra Kampus',
            'slug' => 'mitra-kampus',
            'type' => 'Komunitas',
            'email' => 'mitra@kampus.id',
            'status' => 'active',
        ]);

        // Coba buat kegiatan dengan start_date hari ini (hari yang sama)
        $response = $this->actingAs($panitia)->post(route('organizer.event.store'), [
            'title' => 'Webinar Hari Ini Yang Gagal',
            'type' => 'Webinar',
            'format' => 'online',
            'location' => 'Zoom',
            'start_date' => now()->toDateString(), // Hari ini
            'end_date' => now()->toDateString(),
            'start_time' => '19:00',
            'end_time' => '22:00',
            'quota' => 50,
            'description' => 'Mencoba membuat kegiatan di hari yang sama.',
            'organizer_type' => 'partner',
            'media_partner_id' => $mediaPartner->id,
            'registration_url' => 'https://forms.gle/failToday',
        ]);

        $response->assertSessionHasErrors(['start_date']);
        $this->assertDatabaseMissing('events', ['title' => 'Webinar Hari Ini Yang Gagal']);
    }

    public function test_acara_yang_telah_selesai_tidak_ditampilkan_di_katalog_dan_jelajah_kegiatan_peserta(): void
    {
        $peserta = User::factory()->create(['role' => 'peserta']);

        // Acara aktif mendatang
        $futureEvent = $this->createEvent([
            'title' => 'Acara Masa Depan Yang Masih Aktif',
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
            'status' => 'published',
        ]);

        // Acara lampau / selesai
        $completedEvent = $this->createEvent([
            'title' => 'Acara Masa Lalu Yang Telah Selesai',
            'start_date' => now()->subDays(5)->toDateString(),
            'end_date' => now()->subDays(5)->toDateString(),
            'status' => 'completed',
        ]);

        // 1. Pada katalog publik /kegiatan ("Jelajahi Kegiatan")
        $responseCatalog = $this->get(route('events.index_public'));
        $responseCatalog->assertStatus(200);
        $responseCatalog->assertSee('Acara Masa Depan Yang Masih Aktif');
        $responseCatalog->assertDontSee('Acara Masa Lalu Yang Telah Selesai');

        // 2. Pada dashboard peserta /peserta?tab=kegiatan ("Jelajah Kegiatan Baru")
        $responsePeserta = $this->actingAs($peserta)->get('/peserta?tab=kegiatan');
        $responsePeserta->assertStatus(200);
        $responsePeserta->assertSee('Acara Masa Depan Yang Masih Aktif');
        $responsePeserta->assertDontSee('Acara Masa Lalu Yang Telah Selesai');
    }
}
