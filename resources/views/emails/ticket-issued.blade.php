<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Tiket Resmi Terbit — Eventict</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f1f5f9; padding: 40px 16px;">
    <tr>
      <td align="center">
        <table role="presentation" width="100%" style="max-width: 580px; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
          <tr>
            <td style="background-color: #03194a; padding: 32px 32px 28px; text-align: left;">
              <table role="presentation" width="100%">
                <tr>
                  <td>
                    <h1 style="margin: 0; font-size: 20px; font-weight: 700; color: #ffffff; letter-spacing: -0.02em;">Eventict Lab ICT</h1>
                    <p style="margin: 4px 0 0; font-size: 12px; color: #94a3b8;">Fakultas Teknologi Informasi — Universitas Budi Luhur</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding: 32px 32px 24px;">
              <div style="display: inline-block; padding: 4px 12px; background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 9999px; font-size: 11px; font-weight: 700; color: #065f46; margin-bottom: 16px;">
                E-TIKET RESMI AKTIF
              </div>

              <h2 style="margin: 0 0 16px; font-size: 18px; font-weight: 700; color: #03194a;">Pendaftaran Anda Berhasil!</h2>
              <p style="margin: 0 0 16px; font-size: 14px; line-height: 1.6; color: #475569;">
                Halo <strong>{{ $user->name }}</strong>,
              </p>
              <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #475569;">
                Pendaftaran Anda untuk kegiatan <strong>{{ $event->title }}</strong> telah resmi terkonfirmasi. Tiket elektronik beserta kode akses kehadiran Anda telah diterbitkan dengan rincian sebagai berikut:
              </p>

              <table role="presentation" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;">
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b; width: 140px;">No. Registrasi:</td>
                  <td style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #0f172a; font-family: monospace;">{{ $registration->registration_code }}</td>
                </tr>
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b;">Kode QR Pass:</td>
                  <td style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #03194a; font-family: monospace;">#{{ $registration->qr_pass }}</td>
                </tr>
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b;">Tanggal &amp; Waktu:</td>
                  <td style="padding: 6px 0; font-size: 12px; font-weight: 600; color: #334155;">{{ $event->start_date ? $event->start_date->format('d F Y') : '-' }} &bull; {{ substr($event->start_time ?? '', 0, 5) }} WIB</td>
                </tr>
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b;">Format &amp; Lokasi:</td>
                  <td style="padding: 6px 0; font-size: 12px; color: #334155;">{{ strtoupper($event->format) }} — {{ $event->location }}</td>
                </tr>
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b;">Status Pembayaran:</td>
                  <td style="padding: 6px 0; font-size: 12px; font-weight: 700; color: #059669;">{{ strtoupper($registration->payment_status) }}</td>
                </tr>
              </table>

              <table role="presentation" cellspacing="0" cellpadding="0" style="margin: 0 0 24px;">
                <tr>
                  <td style="border-radius: 10px; background-color: #03194a;">
                    <a href="{{ $portalUrl }}" target="_blank" style="display: inline-block; padding: 12px 28px; font-size: 14px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px;">
                      Buka E-Tiket Saya
                    </a>
                  </td>
                </tr>
              </table>

              <div style="background-color: #eff6ff; border-left: 3px solid #2563eb; padding: 14px 16px; border-radius: 6px; margin: 0 0 20px;">
                <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #1e40af;">
                  <strong>Petunjuk Kehadiran:</strong> Tunjukkan kode tiket atau QR Pass di atas kepada panitia saat check-in di pintu masuk (offline) atau lakukan presensi mandiri pada gerbang presensi sesi (online).
                </p>
              </div>

              <p style="margin: 0; font-size: 12px; color: #94a3b8; line-height: 1.5;">
                Email ini diterbitkan otomatis oleh sistem informasi kegiatan Laboratorium ICT Universitas Budi Luhur.
              </p>
            </td>
          </tr>
          <tr>
            <td style="background-color: #f8fafc; padding: 18px 32px; border-top: 1px solid #e2e8f0; text-align: center;">
              <p style="margin: 0; font-size: 11px; color: #94a3b8;">
                &copy; {{ date('Y') }} Eventict — Laboratorium ICT Universitas Budi Luhur.
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
