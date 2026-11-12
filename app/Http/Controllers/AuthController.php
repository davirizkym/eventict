<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        if ($request->has('nik') && ! $request->has('identity_no')) {
            $request->merge(['identity_no' => $request->input('nik')]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'identity_no' => ['required', 'string', 'regex:/^[0-9]+$/', 'max:20', 'unique:users,identity_no'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'institution' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
        ], [
            'identity_no.required' => 'NIM / NIP / NIS wajib diisi.',
            'identity_no.regex' => 'NIM / NIP / NIS hanya boleh berisi angka.',
            'identity_no.unique' => 'NIM / NIP / NIS ini sudah terdaftar pada akun lain.',
            'identity_no.max' => 'NIM / NIP / NIS maksimal 20 karakter.',
            'email.unique' => 'Alamat email ini sudah terdaftar sebagai pengguna.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal terdiri dari :min karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'identity_no' => $validated['identity_no'],
            'password' => Hash::make($validated['password']),
            'role' => 'peserta',
            'institution' => $validated['institution'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        try {
            event(new \Illuminate\Auth\Events\Registered($user));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Verification email trigger error: ' . $e->getMessage());
        }

        return redirect()->route('verification.notice');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    protected function redirectBasedOnRole(User $user)
    {
        if (in_array($user->role, ['penyelenggara', 'administrator', 'admin'], true)) {
            return redirect()->intended(route('organizer.dashboard'));
        }

        if (! $user->hasVerifiedEmail()) {
            $intended = session()->get('url.intended');
            if ($intended && str_contains($intended, '/email/verifikasi/')) {
                return redirect()->intended(route('peserta.dashboard'));
            }
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(route('peserta.dashboard'));
    }
}
