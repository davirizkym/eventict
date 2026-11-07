<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrganizerController extends Controller
{
    public function hub(Request $request)
    {
        $statusFilter = $request->query('status', 'all');
        $query = Event::with(['speakers'])->withCount([
            'registrations',
            'registrations as attended_count' => function ($q) {
                $q->where('attendance_status', 'attended');
            },
            'registrations as certificates_count' => function ($q) {
                $q->whereHas('certificate');
            }
        ]);

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('category', 'like', "%{$keyword}%")
                    ->orWhere('location', 'like', "%{$keyword}%");
            });
        }

        if ($statusFilter === 'upcoming') {
            $query->whereDate('end_date', '>=', now()->toDateString())->where('status', '!=', 'draft');
        } elseif ($statusFilter === 'past') {
            $query->whereDate('end_date', '<', now()->toDateString())->where('status', '!=', 'draft');
        }

        $events = $query->orderBy('start_date', 'desc')->get();

        $upcomingCount = Event::where('status', '!=', 'draft')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->count();

        $pastCount = Event::where('status', '!=', 'draft')
            ->whereDate('end_date', '<', now()->toDateString())
            ->count();

        $totalSpeakers = Speaker::count();
        $masterSpeakers = Speaker::orderBy('name', 'asc')->get();
        $masterCategories = Category::orderBy('name', 'asc')->get();

        return view('organizer.hub', compact(
            'events',
            'upcomingCount',
            'pastCount',
            'totalSpeakers',
            'statusFilter',
            'masterSpeakers',
            'masterCategories'
        ));
    }

    public function index(Request $request)
    {
        return $this->hub($request);
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|in:Workshop,Seminar,Webinar,Sertifikasi',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string|max:100',
            'format' => 'required|in:online,offline,hybrid',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'quota' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
            'description' => 'required|string',
            'speaker_ids' => 'required_without:speaker_id|array|min:1',
            'speaker_ids.*' => 'required|exists:speakers,id',
            'speaker_roles' => 'nullable|array',
            'speaker_roles.*' => 'nullable|string|max:50',
            'speaker_topics' => 'nullable|array',
            'speaker_topics.*' => 'nullable|string|max:255',
            'speaker_id' => 'nullable|exists:speakers,id',
            'speaker_topic' => 'nullable|string|max:255',
        ], [
            'speaker_ids.required_without' => 'Pengisi acara kegiatan wajib dipilih minimal 1 orang.',
            'speaker_ids.min' => 'Pengisi acara kegiatan wajib dipilih minimal 1 orang.',
            'speaker_ids.*.required' => 'Pengisi acara kegiatan wajib dipilih minimal 1 orang.',
            'speaker_ids.*.exists' => 'Pengisi acara yang dipilih tidak valid.',
        ]);

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $categoryId = $validated['category_id'] ?? null;
        $categoryName = $validated['category'] ?? null;
        if (!empty($categoryId)) {
            $cat = Category::find($categoryId);
            if ($cat) {
                $categoryName = $cat->name;
            }
        } elseif (!empty($categoryName)) {
            $cat = Category::where('name', $categoryName)->first();
            if ($cat) {
                $categoryId = $cat->id;
            }
        }

        if (empty($categoryName)) {
            $categoryName = 'Teknologi & Rekayasa';
        }

        $eventType = !empty($validated['type']) ? $validated['type'] : 'Workshop';

        $event = Event::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => $categoryId,
            'category' => $categoryName,
            'type' => $eventType,
            'format' => $validated['format'],
            'location' => $validated['location'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'quota' => $validated['quota'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'status' => 'published',
            'skp_points' => 0,
        ]);

        $speakerIds = $request->input('speaker_ids', []);
        $speakerRoles = $request->input('speaker_roles', []);
        $speakerTopics = $request->input('speaker_topics', []);

        if (empty($speakerIds) && !empty($validated['speaker_id'])) {
            $speakerIds = [$validated['speaker_id']];
            $speakerRoles = ['Pemateri'];
            $speakerTopics = [$validated['speaker_topic'] ?? 'Sesi Pembicara'];
        }

        $validSpeakers = [];
        $roleCounts = [];

        foreach ($speakerIds as $index => $spkId) {
            if (!empty($spkId)) {
                $rawRole = !empty($speakerRoles[$index]) ? trim($speakerRoles[$index]) : 'Pemateri';
                $roleBase = in_array($rawRole, ['MC', 'Pemateri', 'Moderator']) ? $rawRole : 'Pemateri';
                $roleCounts[$roleBase] = ($roleCounts[$roleBase] ?? 0) + 1;
                $validSpeakers[] = [
                    'id' => $spkId,
                    'base_role' => $roleBase,
                    'topic' => !empty($speakerTopics[$index]) ? trim($speakerTopics[$index]) : null,
                ];
            }
        }

        $roleCounters = [];
        $attachData = [];
        $defaultSessionTime = $validated['start_time'] . ' - ' . $validated['end_time'];

        foreach ($validSpeakers as $item) {
            $base = $item['base_role'];
            if (($roleCounts[$base] ?? 0) > 1) {
                $roleCounters[$base] = ($roleCounters[$base] ?? 0) + 1;
                $finalRole = "{$base} " . $roleCounters[$base];
            } else {
                $finalRole = $base;
            }

            $attachData[$item['id']] = [
                'role' => $finalRole,
                'topic' => $item['topic'] ?? "Sesi {$finalRole}",
                'session_time' => $defaultSessionTime,
            ];
        }

        if (!empty($attachData)) {
            $event->speakers()->sync($attachData);
        }

        return redirect()->route('organizer.workspace', ['event' => $event->id])
            ->with('success', "Kegiatan '{$event->title}' berhasil dibuat. Selamat datang di ruang kerja acara!");
    }

    public function workspace(Request $request, Event $event)
    {
        $tab = $request->query('tab', 'dashboard');
        $event->load(['speakers']);

        $totalRegistrations = $event->registrations()->count();
        $attendedRegistrations = $event->registrations()->where('attendance_status', 'attended')->count();
        $attendancePercentage = $totalRegistrations > 0 ? round(($attendedRegistrations / $totalRegistrations) * 100, 1) : 0;
        $certificatesCount = $event->registrations()->whereHas('certificate')->count();
        $totalRevenue = $event->registrations()->where('payment_status', 'paid')->count() * (float) $event->price;

        $query = $event->registrations()->with(['user', 'certificate'])->latest();

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('registration_code', 'like', "%{$keyword}%")
                    ->orWhere('qr_pass', 'like', "%{$keyword}%")
                    ->orWhereHas('user', function ($uq) use ($keyword) {
                        $uq->where('name', 'like', "%{$keyword}%")
                            ->orWhere('institution', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%")
                            ->orWhere('phone', 'like', "%{$keyword}%");
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

        $allMasterSpeakers = Speaker::orderBy('name', 'asc')->get();
        $allCategories = Category::orderBy('name', 'asc')->get();
        $otherActiveEvents = Event::where('status', '!=', 'draft')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->where('id', '!=', $event->id)
            ->orderBy('start_date', 'asc')
            ->get();

        return view('organizer.workspace', compact(
            'event',
            'tab',
            'registrations',
            'totalRegistrations',
            'attendedRegistrations',
            'attendancePercentage',
            'certificatesCount',
            'totalRevenue',
            'allMasterSpeakers',
            'allCategories',
            'otherActiveEvents'
        ));
    }

    public function updateEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|in:Workshop,Seminar,Webinar,Sertifikasi',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string|max:100',
            'format' => 'required|in:online,offline,hybrid',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'quota' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
            'description' => 'required|string',
            'status' => 'required|in:published,draft,completed',
            'virtual_meeting_url' => 'nullable|url|max:255',
        ]);

        if (!empty($validated['category_id'])) {
            $cat = Category::find($validated['category_id']);
            if ($cat) {
                $validated['category'] = $cat->name;
            }
        }

        $event->update($validated);

        return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'pengaturan'])
            ->with('success', 'Pengaturan kegiatan berhasil diperbarui.');
    }

    public function assignSpeaker(Request $request, Event $event)
    {
        $validated = $request->validate([
            'speaker_id' => 'required|exists:speakers,id',
            'role' => 'nullable|string|max:50',
            'topic' => 'nullable|string|max:255',
            'session_time' => 'nullable|string|max:100',
        ]);

        $speaker = Speaker::findOrFail($validated['speaker_id']);

        $rawRole = !empty($validated['role']) ? trim($validated['role']) : 'Pemateri';
        $baseRole = match ($rawRole) {
            'Moderator' => 'Moderator',
            'MC' => 'MC',
            default => 'Pemateri',
        };

        // Hitung berapa pengisi acara dengan peran dasar yang sama pada acara ini
        $existingCount = $event->speakers()->wherePivot('role', 'like', "{$baseRole}%")->count();
        if ($existingCount > 0) {
            $roleLabel = "{$baseRole} " . ($existingCount + 1);
        } else {
            $roleLabel = $baseRole;
        }

        $defaultTopic = match ($baseRole) {
            'Moderator' => 'Moderator Sesi Acara',
            'MC' => 'Master of Ceremony (MC)',
            default => "Sesi {$roleLabel}",
        };

        $event->speakers()->syncWithoutDetaching([
            $validated['speaker_id'] => [
                'role' => $roleLabel,
                'topic' => !empty($validated['topic']) ? $validated['topic'] : $defaultTopic,
                'session_time' => $validated['session_time'] ?? ($event->start_time . ' - ' . $event->end_time),
            ]
        ]);

        return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'narasumber'])
            ->with('success', "{$roleLabel} ({$speaker->name}) berhasil ditugaskan pada kegiatan ini.");
    }

    public function removeSpeaker(Event $event, Speaker $speaker)
    {
        $event->speakers()->detach($speaker->id);

        return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'narasumber'])
            ->with('success', "Pengisi acara {$speaker->name} berhasil dilepas dari kegiatan ini.");
    }

    public function quickCheckinWorkspace(Request $request, Event $event)
    {
        $request->validate([
            'code' => 'required|string|max:100',
        ]);

        $token = trim($request->code);
        $cleanToken = ltrim($token, '#');

        $registration = Registration::with(['user', 'event'])
            ->where('event_id', $event->id)
            ->where(function ($q) use ($token, $cleanToken) {
                $q->where('registration_code', $token)
                    ->orWhere('registration_code', $cleanToken)
                    ->orWhere('qr_pass', $token)
                    ->orWhereHas('user', function ($uq) use ($token) {
                        $uq->where('email', $token);
                    });
            })
            ->first();

        if (! $registration) {
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta'])
                ->with('error', "Peserta dengan kode atau email '{$token}' tidak ditemukan pada event ini.");
        }

        if ($registration->attendance_status === 'attended') {
            $time = $registration->checked_in_at ? $registration->checked_in_at->format('H:i') . ' WIB' : 'sebelumnya';
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta'])
                ->with('warning', "Peserta {$registration->user->name} ({$registration->registration_code}) sudah presensi pada {$time}.");
        }

        $registration->update([
            'attendance_status' => 'attended',
            'checked_in_at' => now(),
            'check_in_gate' => 'Quick Check-in Lab ICT',
        ]);

        return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta'])
            ->with('success', "Presensi berhasil! {$registration->user->name} ({$registration->registration_code}) ditandai Hadir.");
    }

    public function exportEventPeserta(Event $event)
    {
        $registrations = Registration::with(['user', 'event', 'certificate'])
            ->where('event_id', $event->id)
            ->latest()
            ->get();

        $filename = 'rekap_' . Str::slug($event->title) . '_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return new StreamedResponse(function () use ($registrations) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No.',
                'No. Registrasi',
                'Nama Peserta',
                'Email',
                'Instansi / Universitas',
                'No. Telepon',
                'Nama Acara',
                'Format Acara',
                'Status Pembayaran',
                'Status Kehadiran',
                'Waktu Presensi',
                'Status Sertifikat',
                'Nomor Sertifikat'
            ]);

            foreach ($registrations as $index => $reg) {
                fputcsv($handle, [
                    $index + 1,
                    $reg->registration_code,
                    $reg->user->name ?? '-',
                    $reg->user->email ?? '-',
                    $reg->user->institution ?? '-',
                    $reg->user->phone ?? '-',
                    $reg->event->title ?? '-',
                    strtoupper($reg->event->format ?? '-'),
                    strtoupper($reg->payment_status ?? '-'),
                    $reg->attendance_status === 'attended' ? 'HADIR' : 'BELUM HADIR',
                    $reg->checked_in_at ? $reg->checked_in_at->format('d/m/Y H:i') . ' WIB' : '-',
                    $reg->certificate ? 'TERBIT' : 'BELUM TERBIT',
                    $reg->certificate->certificate_number ?? '-'
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function uploadBatchWorkspace(Request $request, Event $event)
    {
        $request->validate([
            'certificate_files' => 'required|array|min:1',
            'certificate_files.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $uploadedCount = 0;
        $unmatchedFiles = [];
        $files = $request->file('certificate_files');

        foreach ($files as $file) {
            $origName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanCode = trim(str_replace('#', '', $origName));

            $registration = Registration::with('certificate')
                ->where('event_id', $event->id)
                ->where(function ($q) use ($cleanCode, $origName) {
                    $q->where('registration_code', $origName)
                        ->orWhere('registration_code', $cleanCode)
                        ->orWhere('qr_pass', $origName)
                        ->orWhereHas('user', function ($uq) use ($origName) {
                            $uq->where('email', $origName);
                        });
                })
                ->first();

            if (! $registration) {
                $unmatchedFiles[] = $file->getClientOriginalName();
                continue;
            }

            $filename = 'cert_' . $registration->registration_code . '_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('certificates', $filename, 'public');
            $downloadUrl = 'storage/' . $path;

            $certNumber = 'ICT-CERT/' . date('Y') . '/' . str_pad($registration->id, 5, '0', STR_PAD_LEFT);

            Certificate::updateOrCreate(
                ['registration_id' => $registration->id],
                [
                    'certificate_number' => $certNumber,
                    'file_url' => $downloadUrl,
                    'issued_at' => now(),
                ]
            );

            $uploadedCount++;
        }

        $msg = "Berhasil mengunggah {$uploadedCount} sertifikat untuk kegiatan {$event->title}.";
        if (count($unmatchedFiles) > 0) {
            $msg .= " Namun ada " . count($unmatchedFiles) . " file yang tidak cocok: " . implode(', ', array_slice($unmatchedFiles, 0, 3));
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'sertifikat'])->with('warning', $msg);
        }

        return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'sertifikat'])->with('success', $msg);
    }

    public function speakersIndex(Request $request)
    {
        $query = Speaker::withCount('events')->with(['events' => function ($q) {
            $q->orderBy('start_date', 'desc');
        }]);

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('institution', 'like', "%{$keyword}%")
                    ->orWhere('profession', 'like', "%{$keyword}%")
                    ->orWhere('title_degree', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%")
                    ->orWhere('city', 'like', "%{$keyword}%")
                    ->orWhere('topics', 'like', "%{$keyword}%")
                    ->orWhere('bio', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('event_id')) {
            $eventId = (int) $request->query('event_id');
            $query->whereHas('events', function ($eq) use ($eventId) {
                $eq->where('events.id', $eventId);
            });
        }

        if ($request->filled('assignment')) {
            if ($request->query('assignment') === 'assigned') {
                $query->has('events');
            } elseif ($request->query('assignment') === 'unassigned') {
                $query->doesntHave('events');
            }
        }

        if ($request->filled('institution')) {
            $query->where('institution', $request->query('institution'));
        }

        if ($request->filled('city')) {
            $query->where('city', $request->query('city'));
        }

        $sort = $request->query('sort', 'name_asc');
        if ($sort === 'name_desc') {
            $query->orderBy('name', 'desc');
        } elseif ($sort === 'events_desc') {
            $query->orderBy('events_count', 'desc');
        } elseif ($sort === 'latest') {
            $query->orderBy('id', 'desc');
        } else {
            $query->orderBy('name', 'asc');
        }

        $speakers = $query->paginate(10)->withQueryString();
        $allEvents = Event::orderBy('start_date', 'asc')->get();
        $institutions = Speaker::whereNotNull('institution')->where('institution', '!=', '')->distinct()->pluck('institution');
        $cities = Speaker::whereNotNull('city')->where('city', '!=', '')->distinct()->pluck('city');
        $totalSpeakers = Speaker::count();
        $assignedSpeakersCount = Speaker::has('events')->count();
        $totalAssignments = DB::table('event_speaker')->count();

        return view('organizer.speakers.index', compact(
            'speakers',
            'allEvents',
            'institutions',
            'cities',
            'totalSpeakers',
            'assignedSpeakersCount',
            'totalAssignments'
        ));
    }

    public function speakersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'profession' => 'nullable|string|max:255',
            'title_degree' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:100',
            'topics' => 'nullable|string|max:500',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_url' => 'nullable|string|max:500',
        ]);

        $photoUrl = $validated['photo_url'] ?? null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'speaker_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('speakers', $filename, 'public');
            $photoUrl = 'storage/' . $path;
        }

        $speaker = Speaker::create([
            'name' => $validated['name'],
            'institution' => $validated['institution'],
            'profession' => $validated['profession'] ?? null,
            'title_degree' => $validated['title_degree'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'city' => $validated['city'] ?? null,
            'topics' => $validated['topics'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'photo_url' => $photoUrl,
        ]);

        return redirect()->route('organizer.speakers.index')
            ->with('success', "Pengisi acara {$speaker->name} berhasil ditambahkan ke Bank Data.");
    }

    public function speakersShow(Speaker $speaker)
    {
        $speaker->load(['events' => function ($q) {
            $q->orderBy('start_date', 'desc');
        }]);

        $allEvents = Event::orderBy('start_date', 'asc')->get();

        return view('organizer.speakers.show', compact('speaker', 'allEvents'));
    }

    public function speakersUpdate(Request $request, Speaker $speaker)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'profession' => 'nullable|string|max:255',
            'title_degree' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:100',
            'topics' => 'nullable|string|max:500',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_url' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'speaker_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('speakers', $filename, 'public');
            $validated['photo_url'] = 'storage/' . $path;
        }

        unset($validated['photo']);
        $speaker->update($validated);

        return back()->with('success', "Data pengisi acara {$speaker->name} berhasil diperbarui.");
    }

    public function speakersAssignEvents(Request $request, Speaker $speaker)
    {
        $validated = $request->validate([
            'event_ids' => 'nullable|array',
            'event_ids.*' => 'exists:events,id',
            'roles' => 'nullable|array',
            'topics' => 'nullable|array',
            'session_times' => 'nullable|array',
        ]);

        $syncData = [];
        $eventIds = $request->input('event_ids', []);
        $roles = $request->input('roles', []);
        $topics = $request->input('topics', []);
        $sessionTimes = $request->input('session_times', []);

        foreach ($eventIds as $eventId) {
            $syncData[$eventId] = [
                'role' => !empty($roles[$eventId]) ? trim($roles[$eventId]) : 'Pemateri',
                'topic' => !empty($topics[$eventId]) ? trim($topics[$eventId]) : 'Sesi Pemaparan Materi',
                'session_time' => !empty($sessionTimes[$eventId]) ? trim($sessionTimes[$eventId]) : null,
            ];
        }

        $speaker->events()->sync($syncData);

        return back()->with('success', "Penempatan kegiatan untuk pengisi acara {$speaker->name} berhasil diperbarui.");
    }

    public function speakersDestroy(Speaker $speaker)
    {
        $eventsCount = $speaker->events()->count();
        if ($eventsCount > 0) {
            return redirect()->route('organizer.speakers.index')
                ->with('warning', "Pengisi acara {$speaker->name} masih ditugaskan pada {$eventsCount} kegiatan. Lepaskan penugasan terlebih dahulu sebelum menghapus master data.");
        }

        $name = $speaker->name;
        $speaker->delete();

        return redirect()->route('organizer.speakers.index')
            ->with('success', "Data pengisi acara {$name} berhasil dihapus dari Bank Master.");
    }

    public function history(Request $request)
    {
        $query = Event::where('status', '!=', 'draft')
            ->whereDate('end_date', '<', now()->toDateString())
            ->withCount([
                'registrations',
                'registrations as attended_count' => function ($q) {
                    $q->where('attendance_status', 'attended');
                },
                'registrations as certificates_count' => function ($q) {
                    $q->whereHas('certificate');
                }
            ]);

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('category', 'like', "%{$keyword}%");
            });
        }

        $pastEvents = $query->orderBy('start_date', 'desc')->get();
        $pastEventsCount = $pastEvents->count();

        $upcomingCount = Event::where('status', '!=', 'draft')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->count();

        return view('organizer.history', compact('pastEvents', 'pastEventsCount', 'upcomingCount'));
    }

    public function export(Request $request)
    {
        if ($request->filled('event_id') && $request->query('event_id') !== 'all') {
            $event = Event::findOrFail($request->query('event_id'));
            return $this->exportEventPeserta($event);
        }

        $registrations = Registration::with(['user', 'event', 'certificate'])->latest()->get();
        $filename = 'rekap_semua_peserta_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return new StreamedResponse(function () use ($registrations) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No.',
                'No. Registrasi',
                'Nama Peserta',
                'Email',
                'Instansi / Universitas',
                'No. Telepon',
                'Nama Acara',
                'Format Acara',
                'Status Pembayaran',
                'Status Kehadiran',
                'Waktu Presensi',
                'Status Sertifikat',
                'Nomor Sertifikat'
            ]);

            foreach ($registrations as $index => $reg) {
                fputcsv($handle, [
                    $index + 1,
                    $reg->registration_code,
                    $reg->user->name ?? '-',
                    $reg->user->email ?? '-',
                    $reg->user->institution ?? '-',
                    $reg->user->phone ?? '-',
                    $reg->event->title ?? '-',
                    strtoupper($reg->event->format ?? '-'),
                    strtoupper($reg->payment_status ?? '-'),
                    $reg->attendance_status === 'attended' ? 'HADIR' : 'BELUM HADIR',
                    $reg->checked_in_at ? $reg->checked_in_at->format('d/m/Y H:i') . ' WIB' : '-',
                    $reg->certificate ? 'TERBIT' : 'BELUM TERBIT',
                    $reg->certificate->certificate_number ?? '-'
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function quickCheckin(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:100',
        ]);

        $token = trim($request->code);
        $cleanToken = ltrim($token, '#');

        $query = Registration::with(['user', 'event']);

        if ($request->filled('event_id') && $request->event_id !== 'all') {
            $query->where('event_id', $request->event_id);
        }

        $query->where(function ($q) use ($token, $cleanToken) {
            $q->where('registration_code', $token)
                ->orWhere('registration_code', $cleanToken)
                ->orWhere('qr_pass', $token)
                ->orWhereHas('user', function ($uq) use ($token) {
                    $uq->where('email', $token);
                });
        });

        $registration = $query->first();

        if (! $registration) {
            return back()->with('error', "Peserta dengan kode atau email '{$token}' tidak ditemukan.");
        }

        if ($registration->attendance_status === 'attended') {
            $time = $registration->checked_in_at ? $registration->checked_in_at->format('H:i') . ' WIB' : 'sebelumnya';
            return back()->with('warning', "Peserta {$registration->user->name} ({$registration->registration_code}) sudah presensi pada {$time}.");
        }

        $registration->update([
            'attendance_status' => 'attended',
            'checked_in_at' => now(),
            'check_in_gate' => 'Quick Check-in Lab ICT',
        ]);

        return back()->with('success', "Presensi berhasil! {$registration->user->name} ({$registration->registration_code}) ditandai Hadir.");
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
            : 'ICT-CERT/' . date('Y') . '/' . str_pad($registration->id, 5, '0', STR_PAD_LEFT);

        Certificate::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'certificate_number' => $certNumber,
                'file_url' => $downloadUrl,
                'issued_at' => now(),
            ]
        );

        return back()->with('success', "Sertifikat untuk {$registration->user->name} ({$registration->registration_code}) berhasil diunggah.");
    }

    public function uploadBatch(Request $request)
    {
        $request->validate([
            'certificate_files' => 'required|array|min:1',
            'certificate_files.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $uploadedCount = 0;
        $unmatchedFiles = [];
        $files = $request->file('certificate_files');

        foreach ($files as $file) {
            $origName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanCode = trim(str_replace('#', '', $origName));

            $query = Registration::with('certificate');
            if ($request->filled('event_id') && $request->event_id !== 'all') {
                $query->where('event_id', $request->event_id);
            }

            $registration = $query->where(function ($q) use ($cleanCode, $origName) {
                $q->where('registration_code', $origName)
                    ->orWhere('registration_code', $cleanCode)
                    ->orWhere('qr_pass', $origName)
                    ->orWhereHas('user', function ($uq) use ($origName) {
                        $uq->where('email', $origName);
                    });
            })->first();

            if (! $registration) {
                $unmatchedFiles[] = $file->getClientOriginalName();
                continue;
            }

            $filename = 'cert_' . $registration->registration_code . '_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('certificates', $filename, 'public');
            $downloadUrl = 'storage/' . $path;

            $certNumber = 'ICT-CERT/' . date('Y') . '/' . str_pad($registration->id, 5, '0', STR_PAD_LEFT);

            Certificate::updateOrCreate(
                ['registration_id' => $registration->id],
                [
                    'certificate_number' => $certNumber,
                    'file_url' => $downloadUrl,
                    'issued_at' => now(),
                ]
            );

            $uploadedCount++;
        }

        $msg = "Berhasil mengunggah {$uploadedCount} sertifikat.";
        if (count($unmatchedFiles) > 0) {
            $msg .= " Namun ada " . count($unmatchedFiles) . " file yang tidak cocok: " . implode(', ', array_slice($unmatchedFiles, 0, 3));
            return back()->with('warning', $msg);
        }

        return back()->with('success', $msg);
    }

    public function toggleAttendance(Registration $registration)
    {
        $newStatus = $registration->attendance_status === 'attended' ? 'unattended' : 'attended';
        $registration->update([
            'attendance_status' => $newStatus,
            'checked_in_at' => $newStatus === 'attended' ? now() : null,
            'check_in_gate' => $newStatus === 'attended' ? 'Manual Panitia' : null,
        ]);

        $statusText = $newStatus === 'attended' ? 'HADIR' : 'BELUM HADIR';
        return back()->with('success', "Status presensi {$registration->user->name} diubah menjadi {$statusText}.");
    }

    public function deleteCertificate(Registration $registration)
    {
        if ($registration->certificate) {
            $registration->certificate->delete();
            return back()->with('success', "Sertifikat untuk {$registration->user->name} berhasil dihapus.");
        }

        return back()->with('error', 'Sertifikat tidak ditemukan.');
    }

    public function categoriesIndex(Request $request)
    {
        $query = Category::withCount('events');

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        $categories = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return view('organizer.categories.index', compact('categories'));
    }

    public function categoriesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:30',
        ]);

        $category = Category::create([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'] ?? null,
        ]);

        return redirect()->route('organizer.categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil ditambahkan ke katalog master.");
    }

    public function categoriesUpdate(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:30',
        ]);

        $category->update([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'] ?? null,
        ]);

        Event::where('category_id', $category->id)->update(['category' => $category->name]);

        return redirect()->route('organizer.categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil diperbarui.");
    }

    public function categoriesDestroy(Category $category)
    {
        $name = $category->name;
        Event::where('category_id', $category->id)->update(['category_id' => null]);
        $category->delete();

        return redirect()->route('organizer.categories.index')
            ->with('success', "Kategori '{$name}' berhasil dihapus dari sistem.");
    }
}
