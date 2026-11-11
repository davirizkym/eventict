<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function notice(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($request->user());
        }

        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($request->user())->with('status', 'Alamat email Anda sudah terverifikasi.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectBasedOnRole($request->user())->with('status', 'Email berhasil diverifikasi! Selamat datang di Eventict.');
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
