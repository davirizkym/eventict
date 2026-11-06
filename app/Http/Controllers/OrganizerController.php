<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrganizerController extends Controller
{
    public function index(Request $request)
    {
        $activeEvent = Event::with('speakers')->first();
        $events = Event::withCount('registrations')->get();

        $query = Registration::with(['user', 'event', 'certificate'])->latest();

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('registration_code', 'like', "%{$keyword}%")
                    ->orWhere('qr_pass', 'like', "%{$keyword}%")
                    ->orWhereHas('user', function ($uq) use ($keyword) {
                        $uq->where('name', 'like', "%{$keyword}%")
                            ->orWhere('nik', 'like', "%{$keyword}%")
                            ->orWhere('institution', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('attendance')) {
            $query->where('attendance_status', $request->query('attendance'));
        }

        if ($request->filled('certificate')) {
            if ($request->query('certificate') === 'has_cert') {
                $query->has('certificate');
            } elseif ($request->query('certificate') === 'no_cert') {
                $query->doesntHave('certificate');
            }
        }

        $registrations = $query->get();

        $totalRegistrations = Registration::count();
        $totalAttended = Registration::where('attendance_status', 'attended')->count();
        $totalCertificates = Certificate::count();
        $totalRevenue = Registration::where('payment_status', 'paid')
            ->with('event')
            ->get()
            ->sum(function ($r) {
                return $r->event ? (float) $r->event->price : 0;
            });

        return view('organizer.index', compact(
            'activeEvent',
            'events',
            'registrations',
            'totalRegistrations',
            'totalAttended',
            'totalCertificates',
            'totalRevenue'
        ));
    }

    public function uploadSingle(Request $request, Registration $registration)
    {
        $request->validate([
            'certificate_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'certificate_number' => 'nullable|string|max:100',
        ]);

        $file = $request->file('certificate_file');
        $filename = 'cert_' . $registration->registration_code . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('certificates', $filename, 'public');
        $downloadUrl = 'storage/' . $path;

        $certNumber = $request->filled('certificate_number')
            ? $request->certificate_number
            : ('ICT-' . date('Y') . '-' . strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $registration->event->slug ?? 'EVT'), 0, 3)) . '-' . str_pad($registration->id, 4, '0', STR_PAD_LEFT));

        $verifyHash = 'EVT-' . rand(1000, 9999) . '-' . strtoupper(substr(md5(uniqid()), 0, 4));

        Certificate::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'user_id' => $registration->user_id,
                'event_id' => $registration->event_id,
                'certificate_number' => $certNumber,
                'verify_hash' => $verifyHash,
                'issued_at' => now(),
                'download_url' => $downloadUrl,
            ]
        );

        return back()->with('success', 'Sertifikat untuk ' . $registration->user->name . ' berhasil diunggah.');
    }

    public function uploadBatch(Request $request)
    {
        $request->validate([
            'certificate_files' => 'required|array',
            'certificate_files.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $files = $request->file('certificate_files');
        $matched = 0;
        $unmatched = [];

        foreach ($files as $file) {
            $nameOnly = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $token = trim($nameOnly);

            $registration = Registration::where('registration_code', $token)
                ->orWhere('registration_code', '#' . $token)
                ->orWhere('registration_code', 'REG-' . $token)
                ->orWhere('registration_code', 'like', "%{$token}%")
                ->orWhere('qr_pass', $token)
                ->first();

            if (!$registration) {
                $registration = Registration::whereHas('user', function ($q) use ($token) {
                    $q->where('nik', $token)
                        ->orWhere('email', $token);
                })->first();
            }

            if ($registration) {
                $storedName = 'cert_' . $registration->registration_code . '_' . time() . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('certificates', $storedName, 'public');
                $downloadUrl = 'storage/' . $path;

                $certNumber = 'ICT-' . date('Y') . '-' . strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $registration->event->slug ?? 'EVT'), 0, 3)) . '-' . str_pad($registration->id, 4, '0', STR_PAD_LEFT);
                $verifyHash = 'EVT-' . rand(1000, 9999) . '-' . strtoupper(substr(md5(uniqid()), 0, 4));

                Certificate::updateOrCreate(
                    ['registration_id' => $registration->id],
                    [
                        'user_id' => $registration->user_id,
                        'event_id' => $registration->event_id,
                        'certificate_number' => $certNumber,
                        'verify_hash' => $verifyHash,
                        'issued_at' => now(),
                        'download_url' => $downloadUrl,
                    ]
                );

                $matched++;
            } else {
                $unmatched[] = $file->getClientOriginalName();
            }
        }

        if ($matched > 0 && empty($unmatched)) {
            return back()->with('success', "Seluruh {$matched} sertifikat berhasil dipetakan dan diunggah.");
        }

        if ($matched > 0 && !empty($unmatched)) {
            $unmatchedSample = implode(', ', array_slice($unmatched, 0, 4));
            return back()->with('warning', "Berhasil memetakan {$matched} sertifikat. File tidak cocok (" . count($unmatched) . "): {$unmatchedSample}. Pastikan nama file sesuai Nomor Registrasi, NIK, atau Email.");
        }

        return back()->with('error', 'Tidak ada sertifikat yang cocok dengan data peserta. Pastikan nama file menggunakan format Nomor Registrasi (contoh: REG-2026-0104.pdf), NIK, atau Email.');
    }

    public function toggleAttendance(Request $request, Registration $registration)
    {
        $newStatus = $registration->attendance_status === 'attended' ? 'unattended' : 'attended';
        $registration->update([
            'attendance_status' => $newStatus,
            'checked_in_at' => $newStatus === 'attended' ? now() : null,
            'check_in_gate' => $newStatus === 'attended' ? 'Portal Panitia' : null,
        ]);

        $statusText = $newStatus === 'attended' ? 'Hadir' : 'Belum Hadir';
        return back()->with('success', "Status presensi {$registration->user->name} diubah menjadi {$statusText}.");
    }

    public function deleteCertificate(Registration $registration)
    {
        if ($registration->certificate) {
            $registration->certificate->delete();
        }

        return back()->with('success', "Sertifikat untuk {$registration->user->name} berhasil dihapus.");
    }
}
