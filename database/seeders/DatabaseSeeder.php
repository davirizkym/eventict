<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Speaker;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $panitia = User::updateOrCreate(
            ['email' => 'panitia@eventict.id'],
            [
                'name' => 'Sekretariat Panitia Eventict',
                'password' => Hash::make('password123'),
                'role' => 'penyelenggara',
                'institution' => 'PB Ikatan Dokter Indonesia',
                'phone' => '081987654321',
            ]
        );

        $amanda = User::updateOrCreate(
            ['email' => 'amanda@eventict.id'],
            [
                'name' => 'dr. Amanda Putri, Sp.PD',
                'nik' => '3171012345670001',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'institution' => 'RSUP Dr. Cipto Mangunkusumo',
                'phone' => '081234567890',
            ]
        );

        $budi = User::updateOrCreate(
            ['email' => 'budi.santoso@eventict.id'],
            [
                'name' => 'dr. Budi Santoso, Sp.JP',
                'nik' => '3171012345670002',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'institution' => 'RS Jantung dan Pembuluh Darah Harapan Kita',
                'phone' => '081234567891',
            ]
        );

        $nur = User::updateOrCreate(
            ['email' => 'nur.aisyah@eventict.id'],
            [
                'name' => 'dr. Nur Aisyah, M.Kes',
                'nik' => '3171012345670003',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'institution' => 'Dinas Kesehatan Provinsi DKI Jakarta',
                'phone' => '081234567892',
            ]
        );

        $rizky = User::updateOrCreate(
            ['email' => 'rizky.pratama@eventict.id'],
            [
                'name' => 'dr. Rizky Pratama, Sp.A',
                'nik' => '3171012345670004',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'institution' => 'RSUP Fatmawati',
                'phone' => '081234567893',
            ]
        );

        $dewi = User::updateOrCreate(
            ['email' => 'dewi.lestari@eventict.id'],
            [
                'name' => 'dr. Dewi Lestari, Sp.KK',
                'nik' => '3171012345670005',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'institution' => 'RSUD Pasar Minggu',
                'phone' => '081234567894',
            ]
        );

        $fauzi = User::updateOrCreate(
            ['email' => 'ahmad.fauzi@eventict.id'],
            [
                'name' => 'dr. Ahmad Fauzi, M.Biomed',
                'nik' => '3171012345670006',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'institution' => 'Fakultas Kedokteran Universitas Indonesia',
                'phone' => '081234567895',
            ]
        );

        $speaker1 = Speaker::updateOrCreate(
            ['name' => 'Prof. Dr. dr. Faisal Syamsuddin, Sp.JP(K)'],
            [
                'title_degree' => 'Sp.JP(K), FIHA, FACC',
                'institution' => 'Fakultas Kedokteran Universitas Indonesia / RS Jantung Harapan Kita',
                'bio' => 'Guru besar kardiologi dengan spesialisasi intervensi vaskular dan penerapan tele-kardiologi nasional.',
            ]
        );

        $speaker2 = Speaker::updateOrCreate(
            ['name' => 'Dr. Eng. Ir. Hendra Gunawan, S.T., M.Kom'],
            [
                'title_degree' => 'M.Kom, Ph.D, SMIEEE',
                'institution' => 'Pusat Riset Kecerdasan Artifisial Institut Teknologi Bandung',
                'bio' => 'Peneliti utama machine learning pada domain pemrosesan citra medis radiologi dan rekam medis elektronik.',
            ]
        );

        $speaker3 = Speaker::updateOrCreate(
            ['name' => 'dr. Citra Anindita, M.H.Kes'],
            [
                'title_degree' => 'M.H.Kes, C.Med',
                'institution' => 'Biro Hukum & Regulasi Layanan Kesehatan Kemenkes RI',
                'bio' => 'Konsultan hukum kesehatan dalam standardisasi interoperabilitas data SatuSehat dan kepatuhan GDPR medis.',
            ]
        );

        $speaker4 = Speaker::updateOrCreate(
            ['name' => 'Bambang Hidayat, M.Sc, CISSP'],
            [
                'title_degree' => 'M.Sc, CISSP, CISM',
                'institution' => 'Asosiasi Forensik & Keamanan Informasi Medis Indonesia',
                'bio' => 'Praktisi keamanan siber berpengalaman lebih dari 15 tahun dalam arsitektur enkripsi data fasilitas pelayanan kesehatan.',
            ]
        );

        $today = Carbon::today();

        $event1 = Event::updateOrCreate(
            ['slug' => 'simposium-nasional-telemedicine-regulasi-medis-2026'],
            [
                'title' => 'Simposium Nasional Telemedicine & Regulasi Medis 2026',
                'category' => 'Kedokteran & Kesehatan',
                'format' => 'hybrid',
                'location' => 'Ruang Rinjani 2, Hotel Borobudur Jakarta / Akses Zoom Terhubung',
                'start_date' => $today,
                'end_date' => $today,
                'start_time' => '08:30:00',
                'end_time' => '16:00:00',
                'quota' => 400,
                'price' => 350000,
                'skp_points' => 8,
                'sk_number' => '044/PB-IDI/SKP/XI/2026',
                'description' => 'Simposium akreditasi resmi PB IDI membahas regulasi terbaru praktik telekonsultasi, tanggung jawab hukum tenaga medis, dan standardisasi keamanan rekam medis elektronik terintegrasi SatuSehat.',
                'status' => 'published',
                'virtual_meeting_url' => 'https://zoom.us/j/9982440911',
            ]
        );

        $event2 = Event::updateOrCreate(
            ['slug' => 'workshop-machine-learning-intermediate-prediksi-diagnostik'],
            [
                'title' => 'Workshop Machine Learning Intermediate: Prediksi Diagnostik Klinis',
                'category' => 'Teknologi & Rekayasa',
                'format' => 'online',
                'location' => 'Platform Pembelajaran Virtual Eventict',
                'start_date' => $today->copy()->addDays(7),
                'end_date' => $today->copy()->addDays(8),
                'start_time' => '09:00:00',
                'end_time' => '15:30:00',
                'quota' => 150,
                'price' => 0,
                'skp_points' => 32,
                'sk_number' => 'BNSP-TI-2026-881',
                'description' => 'Pelatihan intensif 32 jam pembelajaran bersertifikasi kompetensi BNSP mengenai pembuatan model deep learning untuk analisis citra radiologi diagnostik dan pemetaan tabular rekam medis.',
                'status' => 'published',
                'virtual_meeting_url' => 'https://meet.eventict.id/room-ml-32',
            ]
        );

        $event3 = Event::updateOrCreate(
            ['slug' => 'konferensi-nasional-transformasi-layanan-primer-rme'],
            [
                'title' => 'Konferensi Nasional Transformasi Layanan Primer & Rekam Medis Elektronik',
                'category' => 'Kedokteran & Kesehatan',
                'format' => 'offline',
                'location' => 'Grand Ballroom Pullman Hotel Central Park, Jakarta Barat',
                'start_date' => $today->copy()->addDays(14),
                'end_date' => $today->copy()->addDays(15),
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'quota' => 600,
                'price' => 450000,
                'skp_points' => 12,
                'sk_number' => '089/PB-IDI/SKP/XII/2026',
                'description' => 'Konferensi tahunan pemangku kebijakan rumah sakit dan puskesmas dalam percepatan implementasi rekam medik elektronik serta interoperabilitas data rujukan tingkat lanjut.',
                'status' => 'published',
            ]
        );

        $event4 = Event::updateOrCreate(
            ['slug' => 'simposium-etika-siber-dan-keamanan-privasi-data-pasien'],
            [
                'title' => 'Simposium Etika Siber & Keamanan Privasi Data Pasien',
                'category' => 'Hukum & Kebijakan',
                'format' => 'online',
                'location' => 'Ruang Webinar Live Stream Studio 1',
                'start_date' => $today->copy()->addDays(21),
                'end_date' => $today->copy()->addDays(21),
                'start_time' => '13:00:00',
                'end_time' => '16:30:00',
                'quota' => 300,
                'price' => 175000,
                'skp_points' => 6,
                'sk_number' => 'HK-MED-2026-012',
                'description' => 'Kajian komprehensif undang-undang pelindungan data pribadi (UU PDP) dalam tata kelola basis data fasilitas kesehatan dan mitigasi risiko kebocoran data medis.',
                'status' => 'published',
                'virtual_meeting_url' => 'https://zoom.us/j/7721094432',
            ]
        );

        $event1->speakers()->syncWithoutDetaching([
            $speaker1->id => [
                'topic' => 'Plenary Session: Standar Etik Telehealth Global & Penerapan Klinis',
                'session_time' => '09:00 – 10:30 WIB',
            ],
            $speaker3->id => [
                'topic' => 'Aspek Regulasi Kemenkes & Tanggung Jawab Hukum Dokter Siber',
                'session_time' => '10:45 – 12:15 WIB',
            ],
            $speaker4->id => [
                'topic' => 'Workshop Bedah Kasus: Keamanan Data Pasien & Mitigasi Ransomware',
                'session_time' => '13:30 – 15:30 WIB',
            ],
        ]);

        $event2->speakers()->syncWithoutDetaching([
            $speaker2->id => [
                'topic' => 'Pipeline Preprocessing Citra Medis & Arsitektur Convolutional Neural Networks',
                'session_time' => '09:00 – 12:00 WIB',
            ],
        ]);

        $event3->speakers()->syncWithoutDetaching([
            $speaker1->id => [
                'topic' => 'Integrasi Rujukan Klinis di Era SatuSehat',
                'session_time' => '08:30 – 10:00 WIB',
            ],
            $speaker3->id => [
                'topic' => 'Kebijakan Akreditasi Fasilitas Kesehatan Tingkat Pertama',
                'session_time' => '10:15 – 11:45 WIB',
            ],
        ]);

        $regAmanda1 = Registration::updateOrCreate(
            [
                'user_id' => $amanda->id,
                'event_id' => $event1->id,
            ],
            [
                'registration_code' => 'REG-2026-0104',
                'qr_pass' => 'PASS-9982-AMANDA',
                'payment_status' => 'paid',
                'attendance_status' => 'attended',
                'checked_in_at' => $today->copy()->setTime(8, 24, 12),
                'check_in_gate' => 'Pintu Aula Utama',
                'evaluation_status' => 'completed',
            ]
        );

        $regAmanda2 = Registration::updateOrCreate(
            [
                'user_id' => $amanda->id,
                'event_id' => $event2->id,
            ],
            [
                'registration_code' => 'REG-2026-0205',
                'qr_pass' => 'PASS-3341-AMANDA',
                'payment_status' => 'free',
                'attendance_status' => 'attended',
                'checked_in_at' => $today->copy()->setTime(8, 50, 0),
                'check_in_gate' => 'Gerbang Virtual Zoom',
                'evaluation_status' => 'completed',
            ]
        );

        $regBudi = Registration::updateOrCreate(
            [
                'user_id' => $budi->id,
                'event_id' => $event1->id,
            ],
            [
                'registration_code' => 'REG-2026-0105',
                'qr_pass' => 'PASS-5512-BUDI',
                'payment_status' => 'paid',
                'attendance_status' => 'attended',
                'checked_in_at' => $today->copy()->setTime(8, 26, 40),
                'check_in_gate' => 'Pintu Aula Utama',
                'evaluation_status' => 'completed',
            ]
        );

        $regNur = Registration::updateOrCreate(
            [
                'user_id' => $nur->id,
                'event_id' => $event1->id,
            ],
            [
                'registration_code' => 'REG-2026-0106',
                'qr_pass' => 'PASS-7819-NUR',
                'payment_status' => 'paid',
                'attendance_status' => 'unattended',
                'checked_in_at' => null,
                'check_in_gate' => null,
                'evaluation_status' => 'pending',
            ]
        );

        $regRizky = Registration::updateOrCreate(
            [
                'user_id' => $rizky->id,
                'event_id' => $event1->id,
            ],
            [
                'registration_code' => 'REG-2026-0107',
                'qr_pass' => 'PASS-2290-RIZKY',
                'payment_status' => 'paid',
                'attendance_status' => 'attended',
                'checked_in_at' => $today->copy()->setTime(8, 30, 18),
                'check_in_gate' => 'Pintu Aula Utama',
                'evaluation_status' => 'completed',
            ]
        );

        $regDewi = Registration::updateOrCreate(
            [
                'user_id' => $dewi->id,
                'event_id' => $event1->id,
            ],
            [
                'registration_code' => 'REG-2026-0108',
                'qr_pass' => 'PASS-6614-DEWI',
                'payment_status' => 'paid',
                'attendance_status' => 'attended',
                'checked_in_at' => $today->copy()->setTime(8, 32, 44),
                'check_in_gate' => 'Pintu Aula Timur',
                'evaluation_status' => 'completed',
            ]
        );

        $regFauzi = Registration::updateOrCreate(
            [
                'user_id' => $fauzi->id,
                'event_id' => $event1->id,
            ],
            [
                'registration_code' => 'REG-2026-0109',
                'qr_pass' => 'PASS-9081-FAUZI',
                'payment_status' => 'paid',
                'attendance_status' => 'unattended',
                'checked_in_at' => null,
                'check_in_gate' => null,
                'evaluation_status' => 'pending',
            ]
        );

        Certificate::updateOrCreate(
            ['registration_id' => $regAmanda1->id],
            [
                'user_id' => $amanda->id,
                'event_id' => $event1->id,
                'certificate_number' => 'SKP-2026-X-091',
                'verify_hash' => 'EVT-4409-771B',
                'issued_at' => $today->copy()->setTime(16, 30, 0),
                'download_url' => '/storage/certificates/SKP-2026-X-091.pdf',
            ]
        );

        Certificate::updateOrCreate(
            ['registration_id' => $regAmanda2->id],
            [
                'user_id' => $amanda->id,
                'event_id' => $event2->id,
                'certificate_number' => 'BNSP-2026-ML-419',
                'verify_hash' => 'EVT-8821-390A',
                'issued_at' => $today->copy()->subDays(3)->setTime(17, 0, 0),
                'download_url' => '/storage/certificates/BNSP-2026-ML-419.pdf',
            ]
        );

        Certificate::updateOrCreate(
            ['registration_id' => $regBudi->id],
            [
                'user_id' => $budi->id,
                'event_id' => $event1->id,
                'certificate_number' => 'SKP-2026-X-092',
                'verify_hash' => 'EVT-4409-772C',
                'issued_at' => $today->copy()->setTime(16, 30, 0),
                'download_url' => '/storage/certificates/SKP-2026-X-092.pdf',
            ]
        );

        Certificate::updateOrCreate(
            ['registration_id' => $regRizky->id],
            [
                'user_id' => $rizky->id,
                'event_id' => $event1->id,
                'certificate_number' => 'SKP-2026-X-093',
                'verify_hash' => 'EVT-4409-773D',
                'issued_at' => $today->copy()->setTime(16, 30, 0),
                'download_url' => '/storage/certificates/SKP-2026-X-093.pdf',
            ]
        );

        Certificate::updateOrCreate(
            ['registration_id' => $regDewi->id],
            [
                'user_id' => $dewi->id,
                'event_id' => $event1->id,
                'certificate_number' => 'SKP-2026-X-094',
                'verify_hash' => 'EVT-4409-774E',
                'issued_at' => $today->copy()->setTime(16, 30, 0),
                'download_url' => '/storage/certificates/SKP-2026-X-094.pdf',
            ]
        );
    }
}
