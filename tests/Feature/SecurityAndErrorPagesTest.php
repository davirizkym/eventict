<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityAndErrorPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_custom_404_page_renders_for_non_existent_routes(): void
    {
        $response = $this->get('/kegiatan-yang-pasti-tidak-ada-12345');

        $response->assertStatus(404);
        $response->assertSee('404');
        $response->assertSee('Halaman Tidak Ditemukan');
        $response->assertSee('Ke Halaman Utama');
    }

    public function test_login_endpoint_has_rate_limiting(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $this->post('/login', [
                'email' => 'hacker@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'hacker@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429);
    }
}
