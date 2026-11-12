<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_redirected_to_organizer_dashboard_on_login(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
            'email' => 'admin.test@eventict.id',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin.test@eventict.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('organizer.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_administrator_can_access_all_organizer_menus(): void
    {
        $admin = User::factory()->create(['role' => 'administrator']);

        $hubResponse = $this->actingAs($admin)->get(route('organizer.dashboard'));
        $hubResponse->assertStatus(200);

        $categoriesResponse = $this->actingAs($admin)->get(route('organizer.categories.index'));
        $categoriesResponse->assertStatus(200);

        $speakersResponse = $this->actingAs($admin)->get(route('organizer.speakers.index'));
        $speakersResponse->assertStatus(200);

        $mediaPartnersResponse = $this->actingAs($admin)->get(route('organizer.media_partners.index'));
        $mediaPartnersResponse->assertStatus(200);
    }

    public function test_panitia_and_peserta_cannot_access_user_management(): void
    {
        $panitia = User::factory()->create(['role' => 'penyelenggara']);
        $peserta = User::factory()->create(['role' => 'peserta']);

        $panitiaResponse = $this->actingAs($panitia)->get(route('admin.users.index'));
        $panitiaResponse->assertRedirect(route('organizer.dashboard'));

        $pesertaResponse = $this->actingAs($peserta)->get(route('admin.users.index'));
        $pesertaResponse->assertRedirect(route('peserta.dashboard'));
    }

    public function test_administrator_can_view_all_users_in_management_page(): void
    {
        $admin = User::factory()->create(['role' => 'administrator', 'name' => 'Admin Utama']);
        $panitia = User::factory()->create(['role' => 'penyelenggara', 'name' => 'Panitia Lomba']);
        $peserta = User::factory()->create(['role' => 'peserta', 'name' => 'Peserta Webinar']);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Admin Utama');
        $response->assertSee('Panitia Lomba');
        $response->assertSee('Peserta Webinar');
        $response->assertSee('Kelola User');
    }

    public function test_administrator_can_create_new_user(): void
    {
        $admin = User::factory()->create(['role' => 'administrator']);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Pengguna Baru',
            'email' => 'pengguna.baru@eventict.id',
            'identity_no' => '2210519999',
            'role' => 'penyelenggara',
            'institution' => 'Lab ICT',
            'phone' => '08123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_verified' => '1',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $user = User::where('email', 'pengguna.baru@eventict.id')->first();
        $this->assertNotNull($user);
        $this->assertEquals('penyelenggara', $user->role);
        $this->assertEquals('2210519999', $user->identity_no);
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_administrator_can_update_user(): void
    {
        $admin = User::factory()->create(['role' => 'administrator']);
        $user = User::factory()->create([
            'role' => 'peserta',
            'name' => 'Nama Awal',
            'identity_no' => '1111111111',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user->id), [
            'name' => 'Nama Direvisi',
            'email' => $user->email,
            'identity_no' => '9999999999',
            'role' => 'penyelenggara',
            'institution' => 'Universitas Budi Luhur',
            'phone' => '0899999999',
            'is_verified' => '1',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $fresh = $user->fresh();
        $this->assertEquals('Nama Direvisi', $fresh->name);
        $this->assertEquals('penyelenggara', $fresh->role);
        $this->assertEquals('9999999999', $fresh->identity_no);
    }

    public function test_administrator_can_delete_other_user(): void
    {
        $admin = User::factory()->create(['role' => 'administrator']);
        $user = User::factory()->create(['role' => 'peserta', 'name' => 'User Dihapus']);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user->id));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_administrator_cannot_delete_themselves(): void
    {
        $admin = User::factory()->create(['role' => 'administrator', 'name' => 'Super Admin']);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));

        $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun administrator Anda sendiri.');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_administrator_can_export_users_to_xlsx(): void
    {
        $admin = User::factory()->create(['role' => 'administrator']);
        User::factory()->create(['role' => 'peserta', 'name' => 'Budi Siswa']);

        $response = $this->actingAs($admin)->get(route('admin.users.export'));
        $response->assertStatus(200);
        $this->assertStringContainsString('.xlsx', $response->headers->get('Content-Disposition'));

        ob_start();
        $response->sendContent();
        $content = ob_get_clean();

        $temp = tempnam(sys_get_temp_dir(), 'user_xlsx');
        file_put_contents($temp, $content);
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();
        @unlink($temp);

        $this->assertEquals('Nama Lengkap', $data[0][1]);
        $this->assertEquals('NIM / NIP / NIS', $data[0][3]);
    }

    public function test_administrator_can_toggle_user_verification(): void
    {
        $admin = User::factory()->create(['role' => 'administrator']);
        $user = User::factory()->unverified()->create(['role' => 'peserta']);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle_verify', $user->id));
        $response->assertSessionHas('success');
        $this->assertNotNull($user->fresh()->email_verified_at);

        $response2 = $this->actingAs($admin)->post(route('admin.users.toggle_verify', $user->id));
        $response2->assertSessionHas('success');
        $this->assertNull($user->fresh()->email_verified_at);
    }
}
