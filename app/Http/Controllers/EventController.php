<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('speakers')->where('status', '!=', 'draft');

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhereHas('speakers', function ($sq) use ($keyword) {
                        $sq->where('name', 'like', "%{$keyword}%")
                            ->orWhere('institution', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('format')) {
            $query->where('format', $request->query('format'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $events = $query->orderBy('start_date', 'asc')->get();

        // Kategori dinamis dengan total kegiatan aktif
        $allCategories = Event::where('status', '!=', 'draft')
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->merge(['Kedokteran & Kesehatan', 'Teknologi & Rekayasa', 'Hukum & Kebijakan', 'Ekonomi & Bisnis'])
            ->unique()
            ->values();

        $categoryCounts = Event::where('status', '!=', 'draft')
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category');

        $categories = $this->getPopularCategories($categoryCounts);

        return view('landing', compact('events', 'categories', 'allCategories'));
    }

    public function catalog(Request $request)
    {
        $query = Event::with('speakers')->where('status', '!=', 'draft');

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhereHas('speakers', function ($sq) use ($keyword) {
                        $sq->where('name', 'like', "%{$keyword}%")
                            ->orWhere('institution', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('format')) {
            $query->where('format', $request->query('format'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $events = $query->orderBy('start_date', 'asc')->get();

        $allCategories = Event::where('status', '!=', 'draft')
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->merge(['Kedokteran & Kesehatan', 'Teknologi & Rekayasa', 'Hukum & Kebijakan', 'Ekonomi & Bisnis'])
            ->unique()
            ->values();

        return view('events.catalog', compact('events', 'allCategories'));
    }

    private function getPopularCategories($categoryCounts)
    {
        $definitions = [
            [
                'name' => 'Pemrograman & Web/Mobile',
                'category' => 'Teknologi & Rekayasa',
                'description' => 'Frontend, Backend API, Framework Modern, Aplikasi Mobile',
                'icon' => 'code',
            ],
            [
                'name' => 'Kecerdasan Buatan & Data',
                'category' => 'Teknologi & Rekayasa',
                'description' => 'Machine Learning, Deep Learning, Python Data Science, Analitika',
                'icon' => 'ai',
            ],
            [
                'name' => 'Keamanan Siber & Jaringan',
                'category' => 'Teknologi & Rekayasa',
                'description' => 'Cyber Security, Jaringan Komputer, Infrastruktur Server, Ethical Hacking',
                'icon' => 'security',
            ],
            [
                'name' => 'Teknologi Medis & Telemedicine',
                'category' => 'Kedokteran & Kesehatan',
                'description' => 'Sistem Rekam Medis Elektronik, Interoperabilitas Data Klinis',
                'icon' => 'health',
            ],
            [
                'name' => 'Hukum Siber & Privasi Data',
                'category' => 'Hukum & Kebijakan',
                'description' => 'UU Pelindungan Data Pribadi (UU PDP), Kepatuhan Tata Kelola Digital',
                'icon' => 'law',
            ],
            [
                'name' => 'Bisnis Digital & Manajemen Produk',
                'category' => 'Ekonomi & Bisnis',
                'description' => 'Kewirausahaan Teknologi, Manajemen Produk Digital, Inovasi Startup',
                'icon' => 'business',
            ],
        ];

        $items = collect($definitions)->map(function ($item) use ($categoryCounts) {
            $item['count'] = $categoryCounts[$item['category']] ?? 0;
            return $item;
        });

        // Jika ada kategori lain di database yang belum terdaftar di predefined, sertakan juga secara dinamis
        $covered = collect($definitions)->pluck('category')->unique()->all();
        $extras = Event::where('status', '!=', 'draft')
            ->whereNotIn('category', $covered)
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        foreach ($extras as $extra) {
            $items->push([
                'name' => $extra->category,
                'category' => $extra->category,
                'description' => 'Kumpulan seminar dan workshop bidang ' . $extra->category,
                'icon' => 'default',
                'count' => $extra->total,
            ]);
        }

        return $items;
    }

    public function about()
    {
        return view('pages.about');
    }

    public function show(string $slug)
    {
        $event = Event::with('speakers')->where('slug', $slug)->firstOrFail();

        $isRegistered = false;
        $userRegistration = null;

        if (Auth::check() && Auth::user()->role === 'peserta') {
            $userRegistration = Registration::where('user_id', Auth::id())
                ->where('event_id', $event->id)
                ->first();
            $isRegistered = $userRegistration !== null;
        }

        $registeredCount = $event->registrations()->count();
        $isFull = $registeredCount >= $event->quota;

        return view('events.show', compact('event', 'isRegistered', 'userRegistration', 'registeredCount', 'isFull'));
    }

    public function showRegistrationForm(string $slug)
    {
        $event = Event::with('speakers')->where('slug', $slug)->where('status', '!=', 'draft')->firstOrFail();
        $user = Auth::user();

        $existing = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            return redirect()->route('peserta.dashboard')->with('info', 'Anda sudah terdaftar pada kegiatan ini.');
        }

        $registeredCount = $event->registrations()->count();
        if ($registeredCount >= $event->quota) {
            return redirect()->route('events.show', $slug)->with('error', 'Mohon maaf, kuota peserta untuk kegiatan ini telah penuh.');
        }

        return view('events.register', compact('event', 'user', 'registeredCount'));
    }

    public function registerEvent(Request $request, string $slug)
    {
        $event = Event::where('slug', $slug)->where('status', '!=', 'draft')->firstOrFail();
        $user = Auth::user();

        $existing = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            return redirect()->route('peserta.dashboard')->with('info', 'Anda sudah terdaftar pada kegiatan ini.');
        }

        if ($event->registrations()->count() >= $event->quota) {
            return redirect()->route('events.show', $slug)->with('error', 'Mohon maaf, kuota peserta untuk kegiatan ini telah penuh.');
        }

        $request->validate([
            'nik' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:25'],
            'institution' => ['nullable', 'string', 'max:255'],
            'attendance_mode' => ['nullable', 'string', 'in:offline,online,hybrid'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'agree_terms' => ['required', 'accepted'],
        ], [
            'agree_terms.accepted' => 'Anda wajib menyetujui syarat & ketentuan kehadiran kegiatan.',
            'nik.max' => 'NIM / NIP maksimal 20 karakter.',
        ]);

        // Perbarui data profil peserta jika diisi dan data sebelumnya belum ada
        $userUpdates = [];
        if ($request->filled('nik') && empty($user->nik)) {
            $userUpdates['nik'] = $request->nik;
        }
        if ($request->filled('phone') && empty($user->phone)) {
            $userUpdates['phone'] = $request->phone;
        }
        if ($request->filled('institution') && empty($user->institution)) {
            $userUpdates['institution'] = $request->institution;
        }
        if (!empty($userUpdates)) {
            $user->update($userUpdates);
        }

        $nextNumber = Registration::where('event_id', $event->id)->count() + 1;
        $regCode = 'REG-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        $cleanName = strtoupper(preg_replace('/[^A-Z]/', '', $user->name));
        $cleanName = substr($cleanName, 0, 8) ?: 'USER';
        $qrPass = 'PASS-' . rand(1000, 9999) . '-' . $cleanName;

        Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'registration_code' => $regCode,
            'qr_pass' => $qrPass,
            'payment_status' => $event->price == 0 ? 'free' : 'paid',
            'attendance_status' => 'unattended',
            'evaluation_status' => 'pending',
        ]);

        return redirect()->route('peserta.dashboard')->with('success', 'Pendaftaran berhasil! E-Tiket Anda (' . $regCode . ') telah terbit.');
    }
}
