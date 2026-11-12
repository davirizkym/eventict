<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function notice(Request $request)
    {
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($request->user());
        }

        return view('auth.verify-email');
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            abort(403, 'Tautan verifikasi tidak valid.');
        }

        if (! Auth::check() || Auth::id() !== $user->id) {
            Auth::login($user);
            $request->session()->regenerate();
        }

        if ($user->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($user)->with('status', 'Alamat email Anda sudah terverifikasi.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->redirectBasedOnRole($user)->with('status', 'Email berhasil diverifikasi! Selamat datang di Eventict.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($request->user());
        }

        try {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('status', 'Tautan verifikasi baru telah dikirimkan ke alamat email Anda.');
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => 'Gagal mengirim email: ' . $e->getMessage(),
            ]);
        }
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->role === 'penyelenggara') {
            return redirect()->intended(route('organizer.dashboard'));
        }

        return redirect()->intended(route('peserta.dashboard'));
    }
}
