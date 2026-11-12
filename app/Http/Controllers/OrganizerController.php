<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\MediaPartner;
use App\Models\Registration;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
        if (Category::count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'CategorySeeder', '--force' => true]);
        }
        $masterCategories = Category::orderBy('name', 'asc')->get();
        $masterMediaPartners = MediaPartner::orderBy('name', 'asc')->get();

        return view('organizer.hub', compact(
            'events',
            'upcomingCount',
            'pastCount',
            'totalSpeakers',
            'statusFilter',
            'masterSpeakers',
            'masterCategories',
            'masterMediaPartners'
        ));
    }

    public function index(Request $request)
    {
        return $this->hub($request);
    }

    public function storeEvent(Request $request)
    {
        $organizerTypeInput = $request->input('organizer_type', 'internal');
        $speakerRequiredRule = ($organizerTypeInput === 'partner') ? 'nullable|array' : 'required_without:speaker_id|array|min:1';
        $priceRule = ($organizerTypeInput === 'partner') ? 'nullable|integer|min:0' : 'required|integer|min:0';
        $quotaRule = ($organizerTypeInput === 'partner') ? 'nullable|integer|min:0' : 'required|integer|min:1';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|in:Workshop,Seminar,Webinar,Sertifikasi',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string|max:100',
            'format' => 'required|in:online,offline',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'quota' => $quotaRule,
            'price' => $priceRule,
            'organizer_type' => 'nullable|in:internal,partner',
            'media_partner_id' => 'nullable|exists:media_partners,id',
            'organizer_name' => 'nullable|string|max:255',
            'registration_url' => 'nullable|url|max:500',
            'poster' => 'nullable|image|max:5120',
            'banner_url' => 'nullable|string|max:500',
            'media_partner_ids' => 'nullable|array',
            'media_partner_ids.*' => 'exists:media_partners,id',
            'description' => 'required|string',
            'speaker_ids' => $speakerRequiredRule,
            'speaker_ids.*' => 'nullable|distinct|exists:speakers,id',
            'speaker_roles' => 'nullable|array',
            'speaker_roles.*' => 'nullable|string|max:50',
            'speaker_topics' => 'nullable|array',
            'speaker_topics.*' => 'nullable|string|max:255',
            'speaker_id' => 'nullable|exists:speakers,id',
            'speaker_topic' => 'nullable|string|max:255',
        ], [
            'title.required' => 'Judul kegiatan wajib diisi.',
            'format.required' => 'Format kegiatan (online/offline) wajib dipilih.',
            'location.required' => 'Lokasi atau link platform kegiatan wajib diisi.',
            'start_date.required' => 'Tanggal mulai kegiatan wajib diisi.',
            'start_date.date' => 'Format tanggal mulai kegiatan tidak valid.',
            'start_date.after' => 'Tanggal mulai kegiatan tidak boleh pada hari yang sama atau hari sebelumnya. Kegiatan minimal diselenggarakan mulai besok.',
            'end_date.required' => 'Tanggal selesai kegiatan wajib diisi.',
            'end_date.date' => 'Format tanggal selesai kegiatan tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai kegiatan harus sama dengan atau setelah tanggal mulai.',
            'start_time.required' => 'Jam mulai kegiatan wajib diisi.',
            'end_time.required' => 'Jam selesai kegiatan wajib diisi.',
            'quota.required' => 'Target kuota peserta wajib diisi.',
            'quota.integer' => 'Target kuota peserta harus berupa angka bulat.',
            'quota.min' => 'Target kuota peserta minimal 1 orang.',
            'price.required' => 'Biaya investasi / harga tiket wajib diisi.',
            'price.integer' => 'Biaya investasi harus berupa angka.',
            'price.min' => 'Biaya investasi tidak boleh bernilai negatif.',
            'description.required' => 'Deskripsi rincian kegiatan wajib diisi.',
            'speaker_ids.required_without' => 'Pengisi acara kegiatan wajib dipilih minimal 1 orang.',
            'speaker_ids.min' => 'Pengisi acara kegiatan wajib dipilih minimal 1 orang.',
            'speaker_ids.*.required' => 'Pengisi acara kegiatan wajib dipilih minimal 1 orang.',
            'speaker_ids.*.distinct' => 'Satu orang pengisi acara hanya boleh memiliki 1 peran dalam 1 acara (tidak boleh dipilih lebih dari 1 kali).',
            'speaker_ids.*.exists' => 'Pengisi acara yang dipilih tidak valid.',
        ]);

        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        if ($startDate->lte(Carbon::today())) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['start_date' => 'Tanggal mulai kegiatan tidak boleh pada hari yang sama atau hari sebelumnya. Kegiatan minimal diselenggarakan mulai besok.']);
        }

        $speakerIds = $request->input('speaker_ids', []);
        $filteredSpeakerIds = array_values(array_filter($speakerIds, fn($id) => !empty($id)));
        if (count($filteredSpeakerIds) !== count(array_unique($filteredSpeakerIds))) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['speaker_ids' => 'Satu orang pengisi acara hanya boleh memiliki 1 peran dalam 1 acara (tidak boleh dipilih lebih dari 1 kali).']);
        }

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
        $organizerType = $validated['organizer_type'] ?? 'internal';
        $mediaPartnerId = null;
        $organizerName = 'Laboratorium ICT';
        if ($organizerType === 'partner') {
            $mediaPartnerId = $validated['media_partner_id'] ?? null;
            if (!empty($mediaPartnerId)) {
                $mp = MediaPartner::find($mediaPartnerId);
                $organizerName = $mp ? $mp->name : ($validated['organizer_name'] ?: 'Media Partner');
            } else {
                $organizerName = $validated['organizer_name'] ?: 'Media Partner';
            }
        }

        $bannerUrl = $validated['banner_url'] ?? null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
            $bannerUrl = '/storage/' . $posterPath;
        }

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
            'quota' => ($organizerType === 'partner') ? 0 : (int) ($validated['quota'] ?? 0),
            'price' => ($organizerType === 'partner') ? 0 : (int) ($validated['price'] ?? 0),
            'organizer_type' => $organizerType,
            'media_partner_id' => $mediaPartnerId,
            'organizer_name' => $organizerName,
            'registration_url' => $validated['registration_url'] ?? null,
            'banner_url' => $bannerUrl,
            'description' => $validated['description'],
            'status' => 'published',
        ]);

        if ($request->has('media_partner_ids')) {
            $event->mediaPartners()->sync($request->input('media_partner_ids', []));
        }

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

        $targetTab = ($organizerType === 'partner') ? 'pengaturan' : 'dashboard';
        return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => $targetTab])
            ->with('success', "Kegiatan '{$event->title}' berhasil dibuat. Selamat datang di ruang kerja acara!");
    }

    public function workspace(Request $request, Event $event)
    {
        $isPartner = (($event->organizer_type ?? 'internal') === 'partner');
        $defaultTab = $isPartner ? 'pengaturan' : 'dashboard';
        $tab = $request->query('tab', $defaultTab);

        if ($isPartner && $tab !== 'pengaturan') {
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'pengaturan']);
        }

        $event->load(['speakers']);

        if ($isPartner) {
            $totalRegistrations = 0;
            $checkedInRegistrations = 0;
            $attendedRegistrations = 0;
            $attendancePercentage = 0;
            $certificatesCount = 0;
            $totalRevenue = 0;
            $registrations = collect();
        } else {
            $totalRegistrations = $event->registrations()->count();
            $checkedInRegistrations = $event->registrations()->where('is_checked_in', true)->count();
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
                                ->orWhere('identity_no', 'like', "%{$keyword}%")
                                ->orWhere('institution', 'like', "%{$keyword}%")
                                ->orWhere('email', 'like', "%{$keyword}%")
                                ->orWhere('phone', 'like', "%{$keyword}%");
                        });
                });
            }

            if ($request->filled('checkin') && $event->format === 'offline') {
                $query->where('is_checked_in', $request->query('checkin') === 'checked_in');
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
        }

        $allMasterSpeakers = Speaker::orderBy('name', 'asc')->get();
        if (Category::count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'CategorySeeder', '--force' => true]);
        }
        $allCategories = Category::orderBy('name', 'asc')->get();
        $allMediaPartners = MediaPartner::orderBy('name', 'asc')->get();
        $otherActiveEvents = Event::where('status', '!=', 'draft')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->where('id', '!=', $event->id)
            ->orderBy('start_date', 'asc')
            ->get();

        $event->load('mediaPartners');

        return view('organizer.workspace', compact(
            'event',
            'tab',
            'registrations',
            'totalRegistrations',
            'checkedInRegistrations',
            'attendedRegistrations',
            'attendancePercentage',
            'certificatesCount',
            'totalRevenue',
            'allMasterSpeakers',
            'allCategories',
            'allMediaPartners',
            'otherActiveEvents'
        ));
    }

    public function updateEvent(Request $request, Event $event)
    {
        $organizerTypeInput = $request->input('organizer_type', $event->organizer_type ?? 'internal');
        $priceRule = ($organizerTypeInput === 'partner') ? 'nullable|integer|min:0' : 'required|integer|min:0';
        $quotaRule = ($organizerTypeInput === 'partner') ? 'nullable|integer|min:0' : 'required|integer|min:1';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|in:Workshop,Seminar,Webinar,Sertifikasi',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string|max:100',
            'format' => 'required|in:online,offline',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'quota' => $quotaRule,
            'price' => $priceRule,
            'organizer_type' => 'nullable|in:internal,partner',
            'media_partner_id' => 'nullable|exists:media_partners,id',
            'organizer_name' => 'nullable|string|max:255',
            'registration_url' => 'nullable|url|max:500',
            'poster' => 'nullable|image|max:5120',
            'banner_url' => 'nullable|string|max:500',
            'media_partner_ids' => 'nullable|array',
            'media_partner_ids.*' => 'exists:media_partners,id',
            'description' => 'required|string',
            'status' => 'required|in:published,draft,completed',
            'virtual_meeting_url' => 'nullable|url|max:255',
        ], [
            'title.required' => 'Judul kegiatan wajib diisi.',
            'format.required' => 'Format kegiatan (online/offline) wajib dipilih.',
            'location.required' => 'Lokasi atau link platform kegiatan wajib diisi.',
            'start_date.required' => 'Tanggal mulai kegiatan wajib diisi.',
            'start_date.date' => 'Format tanggal mulai kegiatan tidak valid.',
            'end_date.required' => 'Tanggal selesai kegiatan wajib diisi.',
            'end_date.date' => 'Format tanggal selesai kegiatan tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai kegiatan harus sama dengan atau setelah tanggal mulai.',
            'start_time.required' => 'Jam mulai kegiatan wajib diisi.',
            'end_time.required' => 'Jam selesai kegiatan wajib diisi.',
            'quota.required' => 'Target kuota peserta wajib diisi.',
            'quota.integer' => 'Target kuota peserta harus berupa angka bulat.',
            'quota.min' => 'Target kuota peserta minimal 1 orang.',
            'price.required' => 'Biaya investasi / harga tiket wajib diisi.',
            'price.integer' => 'Biaya investasi harus berupa angka.',
            'price.min' => 'Biaya investasi tidak boleh bernilai negatif.',
            'description.required' => 'Deskripsi rincian kegiatan wajib diisi.',
            'status.required' => 'Status kegiatan wajib dipilih.',
        ]);

        $startDateTime = Carbon::parse($validated['start_date'] . ' ' . $validated['start_time']);
        if ($startDateTime->isPast() && $event->status !== 'completed') {
            return redirect()->back()
                ->withInput()
                ->withErrors(['start_date' => 'Jadwal pelaksanaan kegiatan tidak boleh sebelum waktu saat ini.']);
        }

        if (!empty($validated['category_id'])) {
            $cat = Category::find($validated['category_id']);
            if ($cat) {
                $validated['category'] = $cat->name;
            }
        }

        if (isset($validated['organizer_type'])) {
            if ($validated['organizer_type'] === 'internal') {
                $validated['organizer_name'] = 'Laboratorium ICT';
                $validated['media_partner_id'] = null;
            } else {
                if (!empty($validated['media_partner_id'])) {
                    $mp = MediaPartner::find($validated['media_partner_id']);
                    $validated['organizer_name'] = $mp ? $mp->name : ($validated['organizer_name'] ?: 'Media Partner');
                } elseif (empty($validated['organizer_name'])) {
                    $validated['organizer_name'] = 'Media Partner';
                }
            }
        }

        if ($request->hasFile('poster')) {
            if (!empty($event->banner_url) && str_contains($event->banner_url, 'storage/posters/')) {
                $oldPoster = ltrim(str_replace('/storage/', '', $event->banner_url), '/');
                Storage::disk('public')->delete($oldPoster);
            }
            $posterPath = $request->file('poster')->store('posters', 'public');
            $validated['banner_url'] = '/storage/' . $posterPath;
        }

        $targetOrgType = $validated['organizer_type'] ?? $event->organizer_type;
        if ($targetOrgType === 'partner') {
            $validated['price'] = 0;
            $validated['quota'] = 0;
        } else {
            $validated['price'] = (int) ($validated['price'] ?? $event->price ?? 0);
        }

        $event->update($validated);

        if ($request->has('media_partner_ids')) {
            $event->mediaPartners()->sync($request->input('media_partner_ids', []));
        }

        return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'pengaturan'])
            ->with('success', 'Pengaturan kegiatan berhasil diperbarui.');
    }

    public function destroyEvent(Event $event)
    {
        $title = $event->title;

        if ($event->banner_url && str_starts_with($event->banner_url, '/storage/')) {
            $storagePath = str_replace('/storage/', '', $event->banner_url);
            Storage::disk('public')->delete($storagePath);
        }

        $event->speakers()->detach();
        $event->mediaPartners()->detach();
        $event->delete();

        return redirect()->route('organizer.dashboard')
            ->with('success', "Kegiatan '{$title}' berhasil dihapus.");
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

        if ($event->speakers()->where('speakers.id', $speaker->id)->exists()) {
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'narasumber'])
                ->withErrors(['speaker_id' => "Pengisi acara '{$speaker->name}' sudah ditugaskan dalam kegiatan ini. Satu orang hanya boleh memiliki 1 peran."]);
        }

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

        if ($event->format !== 'offline') {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Check-in registrasi ulang hanya berlaku untuk kegiatan tatap muka (offline).',
                ], 422);
            }
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta'])
                ->with('error', 'Check-in registrasi ulang hanya berlaku untuk kegiatan tatap muka (offline).');
        }

        $token = trim($request->code);
        $cleanToken = ltrim($token, '#');

        $registration = Registration::with(['user', 'event'])
            ->where('event_id', $event->id)
            ->where(function ($q) use ($token, $cleanToken) {
                $q->where('registration_code', $token)
                    ->orWhere('registration_code', $cleanToken)
                    ->orWhere('qr_pass', $token)
                    ->orWhereHas('user', function ($uq) use ($token) {
                        $uq->where('email', $token)
                            ->orWhere('identity_no', $token);
                    });
            })
            ->first();

        if (! $registration) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Peserta dengan kode atau email '{$token}' tidak ditemukan pada kegiatan ini.",
                ], 404);
            }
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta'])
                ->with('error', "Peserta dengan kode atau email '{$token}' tidak ditemukan pada event ini.");
        }

        if ($registration->payment_status === 'pending') {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Peserta {$registration->user->name} ({$registration->registration_code}) belum menyelesaikan pembayaran tiket.",
                ], 422);
            }
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta'])
                ->with('error', "Peserta {$registration->user->name} ({$registration->registration_code}) belum menyelesaikan pembayaran tiket.");
        }

        if ($registration->is_checked_in) {
            $time = $registration->checked_in_at ? $registration->checked_in_at->format('H:i') . ' WIB' : 'sebelumnya';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'already_checked_in',
                    'message' => "Peserta {$registration->user->name} ({$registration->registration_code}) sudah melakukan check-in pada {$time}.",
                    'registration' => [
                        'id' => $registration->id,
                        'name' => $registration->user->name,
                        'registration_code' => $registration->registration_code,
                        'qr_pass' => $registration->qr_pass,
                        'is_checked_in' => true,
                        'checked_in_at' => $time,
                        'check_in_gate' => $registration->check_in_gate,
                    ],
                ], 200);
            }
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta'])
                ->with('warning', "Peserta {$registration->user->name} ({$registration->registration_code}) sudah check-in pada {$time}.");
        }

        $now = now();
        $gate = $request->input('source') === 'camera' ? 'Scan QR Pass (Pintu Masuk)' : 'Quick Check-in Lab ICT';
        $registration->update([
            'is_checked_in' => true,
            'checked_in_at' => $now,
            'check_in_gate' => $gate,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => "Check-in berhasil! {$registration->user->name} ({$registration->registration_code}) terverifikasi masuk.",
                'registration' => [
                    'id' => $registration->id,
                    'name' => $registration->user->name,
                    'registration_code' => $registration->registration_code,
                    'qr_pass' => $registration->qr_pass,
                    'is_checked_in' => true,
                    'checked_in_at' => $now->format('H:i') . ' WIB',
                    'check_in_gate' => $gate,
                ],
            ], 200);
        }

        return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta'])
            ->with('success', "Check-in berhasil! {$registration->user->name} ({$registration->registration_code}) terverifikasi masuk.");
    }

    public function togglePresence(Request $request, Event $event)
    {
        $newStatus = !$event->is_presence_open;
        $token = $newStatus ? Str::random(16) : null;

        $event->update([
            'is_presence_open' => $newStatus,
            'presence_token' => $token,
        ]);

        $message = $newStatus
            ? 'Presensi sesi berhasil dibuka.'
            : 'Presensi sesi berhasil ditutup.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_presence_open' => $newStatus,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    public function stage(Event $event)
    {
        if (!$event->is_presence_open) {
            return redirect()->route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta'])
                ->with('warning', 'Buka presensi sesi terlebih dahulu sebelum menampilkan QR presensi.');
        }

        $event->load(['speakers', 'registrations.user']);
        $attendedCount = $event->registrations->where('attendance_status', 'attended')->count();
        $totalRegistrations = $event->registrations->count();

        return view('organizer.stage', compact('event', 'attendedCount', 'totalRegistrations'));
    }

    public function stageStatus(Event $event)
    {
        $attendedCount = $event->registrations()->where('attendance_status', 'attended')->count();
        $totalRegistrations = $event->registrations()->count();
        $latestAttendees = $event->registrations()
            ->where('attendance_status', 'attended')
            ->with('user')
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(function ($reg) {
                return [
                    'name' => $reg->user->name ?? 'Peserta',
                    'time' => $reg->updated_at ? $reg->updated_at->format('H:i') : '',
                ];
            });

        return response()->json([
            'is_presence_open' => (bool) $event->is_presence_open,
            'attended_count' => $attendedCount,
            'total_registrations' => $totalRegistrations,
            'percentage' => $totalRegistrations > 0 ? round(($attendedCount / $totalRegistrations) * 100) : 0,
            'latest_attendees' => $latestAttendees,
        ]);
    }

    public function exportEventPeserta(Event $event)
    {
        $registrations = Registration::with(['user', 'event', 'certificate'])
            ->where('event_id', $event->id)
            ->latest()
            ->get();

        $filename = 'rekap_' . Str::slug($event->title) . '_' . now()->format('Ymd_His') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Peserta');

        $headers = [
            'No.',
            'No. Registrasi',
            'Nama Peserta',
            'NIM / NIP / NIS',
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
        ];

        $sheet->fromArray([$headers], null, 'A1');

        $rows = [];
        foreach ($registrations as $index => $reg) {
            $rows[] = [
                $index + 1,
                $reg->registration_code,
                $reg->user->name ?? '-',
                $reg->user->identity_no ?? '-',
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
            ];
        }

        if (!empty($rows)) {
            $sheet->fromArray($rows, null, 'A2');
        }

        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:N1')->applyFromArray($headerStyle);

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
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
            $cleanAlphanumeric = preg_replace('/[^a-zA-Z0-9]/', '', $origName);

            $registration = Registration::with('certificate')
                ->where('event_id', $event->id)
                ->where(function ($q) use ($cleanCode, $origName, $cleanAlphanumeric) {
                    $q->where('registration_code', $origName)
                        ->orWhere('registration_code', $cleanCode)
                        ->orWhere('qr_pass', $origName)
                        ->orWhereHas('user', function ($uq) use ($origName, $cleanCode, $cleanAlphanumeric) {
                            $uq->where('email', $origName)
                                ->orWhere('identity_no', $origName)
                                ->orWhere('identity_no', $cleanCode);
                            if (!empty($cleanAlphanumeric)) {
                                $uq->orWhere('identity_no', $cleanAlphanumeric)
                                   ->orWhereRaw("REPLACE(REPLACE(REPLACE(identity_no, '.', ''), '-', ''), ' ', '') = ?", [$cleanAlphanumeric]);
                            }
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
                    'user_id' => $registration->user_id,
                    'event_id' => $registration->event_id,
                    'certificate_number' => $certNumber,
                    'verify_hash' => 'EVT-' . rand(1000, 9999) . '-' . strtoupper(Str::random(4)),
                    'download_url' => $downloadUrl,
                    'issued_at' => now(),
                ]
            );

            if ($registration->attendance_status !== 'attended') {
                $registration->update([
                    'attendance_status' => 'attended',
                    'attended_at' => now(),
                    'attendance_gate' => 'Validasi Sertifikat',
                ]);
            }

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
            if (!empty($speaker->photo_url) && str_contains($speaker->photo_url, 'storage/speakers/')) {
                $oldPhoto = ltrim(str_replace('storage/', '', $speaker->photo_url), '/');
                Storage::disk('public')->delete($oldPhoto);
            }
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

        if (!empty($speaker->photo_url) && str_contains($speaker->photo_url, 'storage/speakers/')) {
            $oldPhoto = ltrim(str_replace('storage/', '', $speaker->photo_url), '/');
            Storage::disk('public')->delete($oldPhoto);
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
        $filename = 'rekap_semua_peserta_' . now()->format('Ymd_His') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Semua Peserta');

        $headers = [
            'No.',
            'No. Registrasi',
            'Nama Peserta',
            'NIM / NIP / NIS',
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
        ];

        $sheet->fromArray([$headers], null, 'A1');

        $rows = [];
        foreach ($registrations as $index => $reg) {
            $rows[] = [
                $index + 1,
                $reg->registration_code,
                $reg->user->name ?? '-',
                $reg->user->identity_no ?? '-',
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
            ];
        }

        if (!empty($rows)) {
            $sheet->fromArray($rows, null, 'A2');
        }

        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:N1')->applyFromArray($headerStyle);

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
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
                    $uq->where('email', $token)
                        ->orWhere('identity_no', $token);
                });
        });

        $registration = $query->first();

        if (! $registration) {
            return back()->with('error', "Peserta dengan kode atau email '{$token}' tidak ditemukan.");
        }

        if ($registration->payment_status === 'pending') {
            return back()->with('error', "Peserta {$registration->user->name} ({$registration->registration_code}) belum menyelesaikan pembayaran tiket.");
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
                'user_id' => $registration->user_id,
                'event_id' => $registration->event_id,
                'certificate_number' => $certNumber,
                'verify_hash' => 'EVT-' . rand(1000, 9999) . '-' . strtoupper(Str::random(4)),
                'download_url' => $downloadUrl,
                'issued_at' => now(),
            ]
        );

        if ($registration->attendance_status !== 'attended') {
            $registration->update([
                'attendance_status' => 'attended',
                'attended_at' => now(),
                'attendance_gate' => 'Validasi Sertifikat',
            ]);
        }

        return redirect()->route('organizer.workspace', ['event' => $registration->event_id, 'tab' => 'sertifikat'])
            ->with('success', "Sertifikat untuk {$registration->user->name} ({$registration->registration_code}) berhasil diunggah.");
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
            $cleanAlphanumeric = preg_replace('/[^a-zA-Z0-9]/', '', $origName);

            $query = Registration::with('certificate');
            if ($request->filled('event_id') && $request->event_id !== 'all') {
                $query->where('event_id', $request->event_id);
            }

            $registration = $query->where(function ($q) use ($cleanCode, $origName, $cleanAlphanumeric) {
                $q->where('registration_code', $origName)
                    ->orWhere('registration_code', $cleanCode)
                    ->orWhere('qr_pass', $origName)
                    ->orWhereHas('user', function ($uq) use ($origName, $cleanCode, $cleanAlphanumeric) {
                        $uq->where('email', $origName)
                            ->orWhere('identity_no', $origName)
                            ->orWhere('identity_no', $cleanCode);
                        if (!empty($cleanAlphanumeric)) {
                            $uq->orWhere('identity_no', $cleanAlphanumeric)
                               ->orWhereRaw("REPLACE(REPLACE(REPLACE(identity_no, '.', ''), '-', ''), ' ', '') = ?", [$cleanAlphanumeric]);
                        }
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
                    'user_id' => $registration->user_id,
                    'event_id' => $registration->event_id,
                    'certificate_number' => $certNumber,
                    'verify_hash' => 'EVT-' . rand(1000, 9999) . '-' . strtoupper(Str::random(4)),
                    'download_url' => $downloadUrl,
                    'issued_at' => now(),
                ]
            );

            if ($registration->attendance_status !== 'attended') {
                $registration->update([
                    'attendance_status' => 'attended',
                    'attended_at' => now(),
                    'attendance_gate' => 'Validasi Sertifikat',
                ]);
            }

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
        if ($registration->attendance_status !== 'attended' && $registration->payment_status === 'pending') {
            return back()->with('error', "Peserta {$registration->user->name} belum menyelesaikan pembayaran tiket.");
        }

        $newStatus = $registration->attendance_status === 'attended' ? 'unattended' : 'attended';
        $registration->update([
            'attendance_status' => $newStatus,
            'attended_at' => $newStatus === 'attended' ? now() : null,
            'attendance_gate' => $newStatus === 'attended' ? 'Manual Panitia' : null,
        ]);

        $statusText = $newStatus === 'attended' ? 'HADIR SESI' : 'BELUM HADIR';
        $notice = ($newStatus === 'unattended' && $registration->certificate()->exists())
            ? ' (Akses e-sertifikat peserta otomatis dibekukan karena status presensi diubah menjadi belum hadir)'
            : '';
        return back()->with('success', "Status presensi {$registration->user->name} diubah menjadi {$statusText}{$notice}.");
    }

    public function toggleCheckin(Registration $registration)
    {
        if ($registration->event->format !== 'offline') {
            return back()->with('error', 'Check-in registrasi ulang hanya berlaku untuk kegiatan offline.');
        }

        if (!$registration->is_checked_in && $registration->payment_status === 'pending') {
            return back()->with('error', "Peserta {$registration->user->name} belum menyelesaikan pembayaran tiket.");
        }

        $newCheckedIn = !$registration->is_checked_in;
        $registration->update([
            'is_checked_in' => $newCheckedIn,
            'checked_in_at' => $newCheckedIn ? now() : null,
            'check_in_gate' => $newCheckedIn ? 'Manual Panitia' : null,
        ]);

        $statusText = $newCheckedIn ? 'SUDAH CHECK-IN' : 'BATAL CHECK-IN';
        return back()->with('success', "Status check-in {$registration->user->name} diubah menjadi {$statusText}.");
    }

    public function deleteCertificate(Registration $registration)
    {
        if ($registration->certificate) {
            $cert = $registration->certificate;
            if (!empty($cert->download_url)) {
                $relativePath = str_replace('storage/', '', ltrim($cert->download_url, '/'));
                \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
            }
            $cert->delete();
            return redirect()->route('organizer.workspace', ['event' => $registration->event_id, 'tab' => 'sertifikat'])
                ->with('success', "Sertifikat untuk {$registration->user->name} berhasil dihapus.");
        }

        return redirect()->route('organizer.workspace', ['event' => $registration->event_id, 'tab' => 'sertifikat'])
            ->with('error', 'Sertifikat tidak ditemukan.');
    }

    public function categoriesIndex(Request $request)
    {
        if (Category::count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'CategorySeeder', '--force' => true]);
        }
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
            'icon' => 'nullable|string|max:100',
            'icon_file' => 'nullable|file|mimes:svg,png,jpg,jpeg,webp|max:2048',
            'color' => 'nullable|string|max:30',
        ]);

        $icon = $validated['icon'] ?? 'sparkles';
        if ($request->hasFile('icon_file')) {
            $file = $request->file('icon_file');
            $filename = 'cat_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories', $filename, 'public');
            $icon = 'storage/' . $path;
        }

        $category = Category::create([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'icon' => $icon,
            'color' => $validated['color'] ?? null,
        ]);

        Event::whereNull('category_id')->where('category', $category->name)->update(['category_id' => $category->id]);

        return redirect()->route('organizer.categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil ditambahkan ke katalog master.");
    }

    public function categoriesUpdate(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'icon_file' => 'nullable|file|mimes:svg,png,jpg,jpeg,webp|max:2048',
            'color' => 'nullable|string|max:30',
        ]);

        $icon = $category->icon;
        if ($request->hasFile('icon_file')) {
            if ($category->icon && str_starts_with($category->icon, 'storage/categories/')) {
                $oldPath = str_replace('storage/', '', $category->icon);
                Storage::disk('public')->delete($oldPath);
            }
            $file = $request->file('icon_file');
            $filename = 'cat_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories', $filename, 'public');
            $icon = 'storage/' . $path;
        } elseif ($request->filled('icon')) {
            if ($category->icon && str_starts_with($category->icon, 'storage/categories/') && $request->input('icon') !== $category->icon) {
                $oldPath = str_replace('storage/', '', $category->icon);
                Storage::disk('public')->delete($oldPath);
            }
            $icon = $request->input('icon');
        }

        $category->update([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'icon' => $icon,
            'color' => $validated['color'] ?? null,
        ]);

        Event::where('category_id', $category->id)->update(['category' => $category->name]);
        Event::whereNull('category_id')->where('category', $category->name)->update(['category_id' => $category->id]);

        return redirect()->route('organizer.categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil diperbarui.");
    }

    public function categoriesDestroy(Category $category)
    {
        $name = $category->name;
        if ($category->icon && str_starts_with($category->icon, 'storage/categories/')) {
            $oldPath = str_replace('storage/', '', $category->icon);
            Storage::disk('public')->delete($oldPath);
        }
        Event::where('category_id', $category->id)->update(['category_id' => null]);
        $category->delete();

        return redirect()->route('organizer.categories.index')
            ->with('success', "Kategori '{$name}' berhasil dihapus dari sistem.");
    }

    public function mediaPartnersIndex(Request $request)
    {
        $query = MediaPartner::withCount('events');

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('institution', 'like', "%{$keyword}%")
                    ->orWhere('contact_email', 'like', "%{$keyword}%");
            });
        }

        $mediaPartners = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return view('organizer.media_partners.index', compact('mediaPartners'));
    }

    public function mediaPartnersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:media_partners,name',
            'institution' => 'nullable|string|max:200',
            'contact_email' => 'required|email|max:150',
            'website_url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ], [
            'name.required' => 'Nama media partner wajib diisi.',
            'name.unique' => 'Nama media partner sudah terdaftar.',
            'contact_email.required' => 'Kontak email wajib diisi.',
            'contact_email.email' => 'Format kontak email tidak valid.',
            'website_url.url' => 'Format URL tautan web / media sosial tidak valid.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus berupa JPEG, PNG, JPG, WebP, atau SVG.',
            'logo.max' => 'Ukuran file logo maksimal 2MB.',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'mp_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media-partners', $filename, 'public');
            $logoPath = 'storage/' . $path;
        }

        $mediaPartner = MediaPartner::create([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['name']),
            'logo' => $logoPath,
            'website_url' => !empty($validated['website_url']) ? trim($validated['website_url']) : null,
            'institution' => $validated['institution'] ?? null,
            'contact_email' => trim($validated['contact_email']),
        ]);

        return redirect()->route('organizer.media_partners.index')
            ->with('success', "Media Partner '{$mediaPartner->name}' berhasil ditambahkan ke master.");
    }

    public function mediaPartnersUpdate(Request $request, MediaPartner $mediaPartner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:media_partners,name,' . $mediaPartner->id,
            'institution' => 'nullable|string|max:200',
            'contact_email' => 'required|email|max:150',
            'website_url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ], [
            'name.required' => 'Nama media partner wajib diisi.',
            'name.unique' => 'Nama media partner sudah terdaftar.',
            'contact_email.required' => 'Kontak email wajib diisi.',
            'contact_email.email' => 'Format kontak email tidak valid.',
            'website_url.url' => 'Format URL tautan web / media sosial tidak valid.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus berupa JPEG, PNG, JPG, WebP, atau SVG.',
            'logo.max' => 'Ukuran file logo maksimal 2MB.',
        ]);

        $logoPath = $mediaPartner->logo;
        if ($request->hasFile('logo')) {
            if ($mediaPartner->logo && str_starts_with($mediaPartner->logo, 'storage/media-partners/')) {
                $oldPath = str_replace('storage/', '', $mediaPartner->logo);
                Storage::disk('public')->delete($oldPath);
            }
            $file = $request->file('logo');
            $filename = 'mp_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media-partners', $filename, 'public');
            $logoPath = 'storage/' . $path;
        }

        $mediaPartner->update([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['name']),
            'logo' => $logoPath,
            'website_url' => !empty($validated['website_url']) ? trim($validated['website_url']) : null,
            'institution' => $validated['institution'] ?? null,
            'contact_email' => trim($validated['contact_email']),
        ]);

        Event::where('media_partner_id', $mediaPartner->id)->update(['organizer_name' => $mediaPartner->name]);

        return redirect()->route('organizer.media_partners.index')
            ->with('success', "Data Media Partner '{$mediaPartner->name}' berhasil diperbarui.");
    }

    public function mediaPartnersDestroy(MediaPartner $mediaPartner)
    {
        $name = $mediaPartner->name;
        if ($mediaPartner->logo && str_starts_with($mediaPartner->logo, 'storage/media-partners/')) {
            $oldPath = str_replace('storage/', '', $mediaPartner->logo);
            Storage::disk('public')->delete($oldPath);
        }
        Event::where('media_partner_id', $mediaPartner->id)->update(['media_partner_id' => null]);
        $mediaPartner->delete();

        return redirect()->route('organizer.media_partners.index')
            ->with('success', "Media Partner '{$name}' berhasil dihapus dari sistem.");
    }
}
