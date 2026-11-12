<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\VerifyNewEmailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AuthEmailFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_can_be_rendered(): void
    {
        $response = $this->get(route('password.request'));
        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi?');
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'peserta.test@eventict.id',
        ]);

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertSessionHas('status');
        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->get(route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Atur Kata Sandi Baru');
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password-123'),
        ]);

        $token = Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
    }

    public function test_registration_triggers_verification_email(): void
    {
        Notification::fake();

        $response = $this->post(route('register'), [
            'name' => 'Siswa Baru',
            'email' => 'siswa.baru@eventict.id',
            'identity_no' => '2210511001',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'institution' => 'SMK 1 Budi Luhur',
        ]);

        $response->assertRedirect(route('verification.notice'));
        $user = User::where('email', 'siswa.baru@eventict.id')->first();
        $this->assertNotNull($user);
        $this->assertEquals('2210511001', $user->identity_no);
        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    public function test_registration_requires_identity_no(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Siswa Baru',
            'email' => 'siswa.tanpa.nik@eventict.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'institution' => 'SMK 1 Budi Luhur',
        ]);

        $response->assertSessionHasErrors(['identity_no']);
        $this->assertDatabaseMissing('users', ['email' => 'siswa.tanpa.nik@eventict.id']);
    }

    public function test_registration_requires_numeric_identity_no(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Siswa Test',
            'email' => 'siswa.invalid.nim@eventict.id',
            'identity_no' => 'saya ganteng',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'institution' => 'SMK 1 Budi Luhur',
        ]);

        $response->assertSessionHasErrors(['identity_no']);
        $this->assertDatabaseMissing('users', ['email' => 'siswa.invalid.nim@eventict.id']);
    }

    public function test_registration_requires_unique_identity_no(): void
    {
        User::factory()->create([
            'identity_no' => '2210511001',
        ]);

        $response = $this->post(route('register'), [
            'name' => 'Siswa Lain',
            'email' => 'siswa.lain@eventict.id',
            'identity_no' => '2210511001',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'institution' => 'SMK 1 Budi Luhur',
        ]);

        $response->assertSessionHasErrors(['identity_no']);
        $this->assertDatabaseMissing('users', ['email' => 'siswa.lain@eventict.id']);
    }

    public function test_unverified_participant_cannot_access_peserta_dashboard(): void
    {
        $user = User::factory()->unverified()->create(['role' => 'peserta']);

        $response = $this->actingAs($user)->get(route('peserta.dashboard'));

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_verified_participant_can_access_peserta_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'peserta']);

        $response = $this->actingAs($user)->get(route('peserta.dashboard'));

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('peserta.dashboard'));
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_unverified_user_can_resend_verification_email(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->post(route('verification.send'));

        $response->assertSessionHas('status');
        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    public function test_guest_can_verify_email_via_signed_link(): void
    {
        $user = User::factory()->unverified()->create(['role' => 'peserta']);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->get($verificationUrl);

        $response->assertRedirect(route('peserta.dashboard'));
        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->assertAuthenticatedAs($user);
    }

    public function test_participant_can_update_profile_without_changing_email(): void
    {
        $user = User::factory()->create([
            'role' => 'peserta',
            'name' => 'Nama Lama',
            'email' => 'peserta.tetap@eventict.id',
            'identity_no' => '2210511001',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->put(route('peserta.profile.update'), [
            'name' => 'Nama Baru',
            'email' => 'peserta.tetap@eventict.id',
            'identity_no' => '2210511002',
            'institution' => 'Universitas Budi Luhur',
            'phone' => '08123456789',
        ]);

        $response->assertRedirect(route('peserta.dashboard', ['tab' => 'profil']));
        $response->assertSessionHas('success');

        $fresh = $user->fresh();
        $this->assertEquals('Nama Baru', $fresh->name);
        $this->assertEquals('peserta.tetap@eventict.id', $fresh->email);
        $this->assertEquals('2210511002', $fresh->identity_no);
        $this->assertNotNull($fresh->email_verified_at);
    }

    public function test_participant_updating_identity_no_requires_numeric(): void
    {
        $user = User::factory()->create([
            'role' => 'peserta',
            'email' => 'peserta.numeric@eventict.id',
            'identity_no' => '2210511001',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->put(route('peserta.profile.update'), [
            'name' => 'Nama Baru',
            'email' => 'peserta.numeric@eventict.id',
            'identity_no' => 'saya ganteng',
            'institution' => 'Universitas Budi Luhur',
        ]);

        $response->assertSessionHasErrors(['identity_no']);
        $this->assertEquals('2210511001', $user->fresh()->identity_no);
    }

    public function test_participant_updating_email_requires_reverification(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'role' => 'peserta',
            'email' => 'lama@eventict.id',
            'identity_no' => '2210511001',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->put(route('peserta.profile.update'), [
            'name' => $user->name,
            'email' => 'baru@eventict.id',
            'identity_no' => '2210511001',
            'institution' => 'FTI Budi Luhur',
        ]);

        $response->assertRedirect(route('peserta.dashboard', ['tab' => 'profil']));
        $response->assertSessionHas('status');

        $fresh = $user->fresh();
        $this->assertEquals('lama@eventict.id', $fresh->email);
        $this->assertEquals('baru@eventict.id', $fresh->pending_email);
        $this->assertNotNull($fresh->email_verified_at);

        Notification::assertSentOnDemand(VerifyNewEmailNotification::class, function ($notification, $channels, $notifiable) {
            return $notifiable->routes['mail'] === 'baru@eventict.id';
        });

        Auth::logout();
        $loginWithOldEmail = $this->post(route('login'), [
            'email' => 'lama@eventict.id',
            'password' => 'password123',
        ]);
        $loginWithOldEmail->assertRedirect(route('peserta.dashboard'));
        $this->assertAuthenticatedAs($user);

        Auth::logout();
        $loginWithNewEmailBeforeVerify = $this->post(route('login'), [
            'email' => 'baru@eventict.id',
            'password' => 'password123',
        ]);
        $loginWithNewEmailBeforeVerify->assertSessionHasErrors(['email']);
        $this->assertGuest();

        $verificationUrl = URL::temporarySignedRoute(
            'profile.email.verify',
            now()->addMinutes(60),
            ['id' => $fresh->id, 'hash' => sha1('baru@eventict.id')]
        );

        $verifyResponse = $this->get($verificationUrl);
        $verifyResponse->assertRedirect(route('peserta.dashboard', ['tab' => 'profil']));
        $verifyResponse->assertSessionHas('success');

        $afterVerify = $fresh->fresh();
        $this->assertEquals('baru@eventict.id', $afterVerify->email);
        $this->assertNull($afterVerify->pending_email);
        $this->assertNotNull($afterVerify->email_verified_at);
        $this->assertAuthenticatedAs($afterVerify);

        Auth::logout();
        $loginWithNewEmailAfterVerify = $this->post(route('login'), [
            'email' => 'baru@eventict.id',
            'password' => 'password123',
        ]);
        $loginWithNewEmailAfterVerify->assertRedirect(route('peserta.dashboard'));
    }

    public function test_participant_can_cancel_pending_email(): void
    {
        $user = User::factory()->create([
            'role' => 'peserta',
            'email' => 'aktif@eventict.id',
            'pending_email' => 'tertunda@eventict.id',
        ]);

        $response = $this->actingAs($user)->post(route('peserta.profile.email.cancel'));

        $response->assertRedirect(route('peserta.dashboard', ['tab' => 'profil']));
        $this->assertNull($user->fresh()->pending_email);
    }

    public function test_participant_cannot_update_email_to_already_used_email(): void
    {
        User::factory()->create(['email' => 'sudah.ada@eventict.id']);

        $user = User::factory()->create([
            'role' => 'peserta',
            'email' => 'saya@eventict.id',
        ]);

        $response = $this->actingAs($user)->put(route('peserta.profile.update'), [
            'name' => $user->name,
            'email' => 'sudah.ada@eventict.id',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals('saya@eventict.id', $user->fresh()->email);
    }
}
