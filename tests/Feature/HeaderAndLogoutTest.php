<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeaderAndLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_header_is_rendered_consistently_on_all_organizer_pages(): void
    {
        $organizer = User::factory()->create([
            'role' => 'penyelenggara',
            'name' => 'Budi Santoso',
            'institution' => 'Lab ICT',
        ]);

        $pages = [
            route('organizer.dashboard'),
            route('organizer.categories.index'),
            route('organizer.speakers.index'),
            route('organizer.media_partners.index'),
        ];

        foreach ($pages as $url) {
            $response = $this->actingAs($organizer)->get($url);
            $response->assertStatus(200);
            $response->assertSee('Lihat Website');
            $response->assertSee('Budi Santoso');
            $response->assertSee('confirmLogout', false);
            $response->assertSee('logout-confirm-modal');
            $response->assertSee('Konfirmasi Keluar');
        }
    }

    public function test_peserta_header_renders_profile_widget_and_logout_modal(): void
    {
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'name' => 'Siti Rahma',
            'institution' => 'Universitas Indonesia',
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Portal Peserta');
        $response->assertSee('Lihat Website');
        $response->assertSee('Siti Rahma');
        $response->assertSee('Universitas Indonesia');
        $response->assertSee('logout-form-peserta');
        $response->assertSee('confirmLogout', false);
        $response->assertSee('logout-confirm-modal');
        $response->assertSee('Konfirmasi Keluar');
    }

    public function test_logout_endpoint_clears_session(): void
    {
        $user = User::factory()->create(['role' => 'peserta']);

        $response = $this->actingAs($user)->post(route('logout'));
        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }
}
