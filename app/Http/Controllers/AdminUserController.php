<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::count();
        $totalAdmins = User::whereIn('role', ['administrator', 'admin'])->count();
        $totalPanitia = User::where('role', 'penyelenggara')->count();
        $totalPeserta = User::where('role', 'peserta')->count();

        $query = User::query()->latest('id');

        if ($request->filled('q')) {
            $keyword = trim($request->query('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('identity_no', 'like', "%{$keyword}%")
                    ->orWhere('institution', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $roleFilter = $request->query('role');
            if ($roleFilter === 'administrator') {
                $query->whereIn('role', ['administrator', 'admin']);
            } else {
                $query->where('role', $roleFilter);
            }
        }

        if ($request->filled('status_email') && $request->status_email !== 'all') {
            if ($request->status_email === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status_email === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'totalAdmins',
            'totalPanitia',
            'totalPeserta'
        ));
    }

    public function store(Request $request)
    {
        if ($request->has('nik') && ! $request->has('identity_no')) {
            $request->merge(['identity_no' => $request->input('nik')]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'identity_no' => ['required', 'string', 'regex:/^[0-9]+$/', 'max:20', 'unique:users,identity_no'],
            'role' => 'required|string|in:administrator,penyelenggara,peserta',
            'institution' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:25',
            'password' => 'required|string|min:8|confirmed',
            'is_verified' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan oleh akun lain.',
            'identity_no.required' => 'NIM / NIP / NIS wajib diisi.',
            'identity_no.regex' => 'NIM / NIP / NIS hanya boleh berisi angka.',
            'identity_no.unique' => 'NIM / NIP / NIS ini sudah digunakan oleh akun lain.',
            'identity_no.max' => 'NIM / NIP / NIS maksimal 20 karakter.',
            'role.required' => 'Role pengguna wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'identity_no' => trim($validated['identity_no']),
            'role' => $validated['role'],
            'institution' => !empty($validated['institution']) ? trim($validated['institution']) : null,
            'phone' => !empty($validated['phone']) ? trim($validated['phone']) : null,
            'password' => Hash::make($validated['password']),
            'email_verified_at' => $request->boolean('is_verified', true) ? now() : null,
        ]);

        return redirect()->route('admin.users.index')->with('success', "Akun pengguna '{$user->name}' berhasil dibuat.");
    }

    public function update(Request $request, User $user)
    {
        if ($request->has('nik') && ! $request->has('identity_no')) {
            $request->merge(['identity_no' => $request->input('nik')]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'identity_no' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'max:20',
                Rule::unique('users', 'identity_no')->ignore($user->id),
            ],
            'role' => 'required|string|in:administrator,penyelenggara,peserta',
            'institution' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:25',
            'password' => 'nullable|string|min:8|confirmed',
            'is_verified' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan oleh akun lain.',
            'identity_no.required' => 'NIM / NIP / NIS wajib diisi.',
            'identity_no.regex' => 'NIM / NIP / NIS hanya boleh berisi angka.',
            'identity_no.unique' => 'NIM / NIP / NIS ini sudah digunakan oleh akun lain.',
            'identity_no.max' => 'NIM / NIP / NIS maksimal 20 karakter.',
            'role.required' => 'Role pengguna wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if ($user->id === Auth::id() && $validated['role'] !== $user->role) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun administrator Anda sendiri.');
        }

        $updates = [
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'identity_no' => trim($validated['identity_no']),
            'role' => $validated['role'],
            'institution' => !empty($validated['institution']) ? trim($validated['institution']) : null,
            'phone' => !empty($validated['phone']) ? trim($validated['phone']) : null,
        ];

        if (!empty($validated['password'])) {
            $updates['password'] = Hash::make($validated['password']);
        }

        if ($request->has('is_verified')) {
            $updates['email_verified_at'] = $request->boolean('is_verified') ? ($user->email_verified_at ?? now()) : null;
        }

        $user->update($updates);

        return redirect()->route('admin.users.index')->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun administrator Anda sendiri.');
        }

        $userName = $user->name;

        $user->registrations()->delete();
        $user->certificates()->delete();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "Akun pengguna '{$userName}' berhasil dihapus.");
    }

    public function exportXlsx(Request $request)
    {
        $query = User::query()->latest('id');

        if ($request->filled('q')) {
            $keyword = trim($request->query('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('identity_no', 'like', "%{$keyword}%")
                    ->orWhere('institution', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $roleFilter = $request->query('role');
            if ($roleFilter === 'administrator') {
                $query->whereIn('role', ['administrator', 'admin']);
            } else {
                $query->where('role', $roleFilter);
            }
        }

        if ($request->filled('status_email') && $request->status_email !== 'all') {
            if ($request->status_email === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status_email === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->get();
        $filename = 'rekap_pengguna_eventict_' . now()->format('Ymd_His') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Master Pengguna');

        $headers = [
            'No.',
            'Nama Lengkap',
            'Alamat Email',
            'NIM / NIP / NIS',
            'Role Akses',
            'Instansi / Perusahaan',
            'No. Telepon',
            'Status Email',
            'Waktu Verifikasi',
            'Tanggal Terdaftar',
        ];

        $sheet->fromArray([$headers], null, 'A1');

        $rows = [];
        foreach ($users as $index => $u) {
            $rows[] = [
                $index + 1,
                $u->name,
                $u->email,
                $u->identity_no ?? '-',
                strtoupper($u->role),
                $u->institution ?? '-',
                $u->phone ?? '-',
                $u->hasVerifiedEmail() ? 'TERVERIFIKASI' : 'BELUM VERIFIKASI',
                $u->email_verified_at ? $u->email_verified_at->format('d/m/Y H:i') . ' WIB' : '-',
                $u->created_at ? $u->created_at->format('d/m/Y H:i') . ' WIB' : '-',
            ];
        }

        if (!empty($rows)) {
            $sheet->fromArray($rows, null, 'A2');
        }

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function resendVerification(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('error', "Alamat email {$user->name} sudah terverifikasi sebelumnya.");
        }

        try {
            $user->sendEmailVerificationNotification();
            return back()->with('success', "Tautan verifikasi email berhasil dikirimkan ulang ke {$user->email}.");
        } catch (\Throwable $e) {
            return back()->with('error', "Gagal mengirim email: " . $e->getMessage());
        }
    }

    public function toggleVerify(User $user)
    {
        $user->email_verified_at = $user->hasVerifiedEmail() ? null : now();
        $user->save();

        $statusText = $user->hasVerifiedEmail() ? 'terverifikasi aktif' : 'belum terverifikasi';
        return back()->with('success', "Status email akun '{$user->name}' berhasil diubah menjadi {$statusText}.");
    }
}
