<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
