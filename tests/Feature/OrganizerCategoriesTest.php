<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizerCategoriesTest extends TestCase
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

    public function test_guest_cannot_access_categories(): void
    {
        $response = $this->get('/penyelenggara/kategori');
        $response->assertRedirect('/login');
    }

    public function test_categories_index_page_loads_and_displays_category_list(): void
    {
        $panitia = $this->createPanitia();

        Category::create([
            'name' => 'Cyber Security',
            'slug' => 'cyber-security',
            'description' => 'Keamanan jaringan, penetration testing, ethical hacking, digital forensics.',
            'color' => '#dc2626',
        ]);

        $response = $this->actingAs($panitia)->get('/penyelenggara/kategori');

        $response->assertStatus(200);
        $response->assertSee('Master Kategori Acara');
        $response->assertSee('Cyber Security');
        $response->assertSee('Keamanan jaringan, penetration testing');
        $response->assertSee('Tambah Kategori Baru');
    }

    public function test_categories_index_searches_by_name(): void
    {
        $panitia = $this->createPanitia();

        Category::create([
            'name' => 'Cyber Security',
            'slug' => 'cyber-security',
            'description' => 'Keamanan jaringan.',
            'color' => '#dc2626',
        ]);

        Category::create([
            'name' => 'Data Science & AI',
            'slug' => 'data-science-ai',
            'description' => 'Machine learning dan deep learning.',
            'color' => '#2563eb',
        ]);

        $response = $this->actingAs($panitia)->get('/penyelenggara/kategori?q=Cyber');

        $response->assertStatus(200);
        $response->assertSee('Cyber Security');
        $response->assertDontSee('Data Science & AI');
    }

    public function test_can_create_new_category(): void
    {
        $panitia = $this->createPanitia();

        $data = [
            'name' => 'Internet of Things & Embedded Systems',
            'description' => 'Pengembangan mikrokontroler Arduino, ESP32, Raspberry Pi, dan otomasi industri.',
            'color' => '#059669',
        ];

        $response = $this->actingAs($panitia)->post('/penyelenggara/kategori', $data);

        $response->assertRedirect('/penyelenggara/kategori');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categories', [
            'name' => 'Internet of Things & Embedded Systems',
            'slug' => 'internet-of-things-embedded-systems',
            'color' => '#059669',
        ]);
    }

    public function test_create_category_fails_validation_if_name_missing_or_duplicate(): void
    {
        $panitia = $this->createPanitia();

        Category::create([
            'name' => 'Cyber Security',
            'slug' => 'cyber-security',
        ]);

        // Duplicate name
        $responseDuplicate = $this->actingAs($panitia)->post('/penyelenggara/kategori', [
            'name' => 'Cyber Security',
        ]);
        $responseDuplicate->assertSessionHasErrors(['name']);

        // Empty name
        $responseEmpty = $this->actingAs($panitia)->post('/penyelenggara/kategori', [
            'name' => '',
        ]);
        $responseEmpty->assertSessionHasErrors(['name']);
    }

    public function test_can_update_existing_category_and_synchronizes_events(): void
    {
        $panitia = $this->createPanitia();

        $cat = Category::create([
            'name' => 'Web Dev',
            'slug' => 'web-dev',
            'description' => 'Web development lama.',
            'color' => '#3b82f6',
        ]);

        $event = Event::create([
            'title' => 'Workshop Fullstack Laravel',
            'category_id' => $cat->id,
            'category' => 'Web Dev',
            'type' => 'Workshop',
            'slug' => 'workshop-fullstack-laravel-' . uniqid(),
            'description' => 'Belajar fullstack',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'location' => 'Lab ICT 1',
            'quota' => 40,
            'price' => 50000,
            'status' => 'published',
            'format' => 'offline',
        ]);

        $updateData = [
            'name' => 'Modern Web & Fullstack Engineering',
            'description' => 'Pengembangan modern web dengan framework terbaru.',
            'color' => '#1d4ed8',
        ];

        $response = $this->actingAs($panitia)->put("/penyelenggara/kategori/{$cat->id}", $updateData);

        $response->assertRedirect('/penyelenggara/kategori');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categories', [
            'id' => $cat->id,
            'name' => 'Modern Web & Fullstack Engineering',
            'slug' => 'modern-web-fullstack-engineering',
        ]);

        // Event category string should be synchronized
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'category' => 'Modern Web & Fullstack Engineering',
        ]);
    }

    public function test_can_delete_category_safely(): void
    {
        $panitia = $this->createPanitia();

        $cat = Category::create([
            'name' => 'Kategori Sementara',
            'slug' => 'kategori-sementara',
        ]);

        $event = Event::create([
            'title' => 'Event Eksperimen',
            'category_id' => $cat->id,
            'category' => 'Kategori Sementara',
            'type' => 'Seminar',
            'slug' => 'event-eksperimen-' . uniqid(),
            'description' => 'Seminar uji coba',
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'location' => 'Online',
            'quota' => 50,
            'price' => 0,
            'status' => 'published',
            'format' => 'online',
        ]);

        $response = $this->actingAs($panitia)->delete("/penyelenggara/kategori/{$cat->id}");

        $response->assertRedirect('/penyelenggara/kategori');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('categories', [
            'id' => $cat->id,
        ]);

        // Event should still exist and category_id set null
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'category_id' => null,
        ]);
    }
}
