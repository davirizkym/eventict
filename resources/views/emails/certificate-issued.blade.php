<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Sertifikat Telah Terbit — Eventict</title>
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
              <div style="display: inline-block; padding: 4px 12px; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 9999px; font-size: 11px; font-weight: 700; color: #1e40af; margin-bottom: 16px;">
                E-SERTIFIKAT RESMI TERBIT
              </div>

              <h2 style="margin: 0 0 16px; font-size: 18px; font-weight: 700; color: #03194a;">Selamat, E-Sertifikat Anda Telah Terbit!</h2>
              <p style="margin: 0 0 16px; font-size: 14px; line-height: 1.6; color: #475569;">
                Halo <strong>{{ $user->name }}</strong>,
              </p>
              <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #475569;">
                Panitia pelaksana telah menerbitkan E-Sertifikat resmi untuk keikutsertaan Anda dalam kegiatan <strong>{{ $event->title }}</strong>. Dokumen ini telah diverifikasi dan siap diunduh melalui web Eventict.
              </p>

              <table role="presentation" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;">
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b; width: 140px;">Nama Peserta:</td>
                  <td style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #0f172a;">{{ $user->name }}</td>
                </tr>
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b;">No. Sertifikat:</td>
                  <td style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #03194a; font-family: monospace;">{{ $certificate->certificate_number }}</td>
                </tr>
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b;">ID Keabsahan:</td>
                  <td style="padding: 6px 0; font-size: 12px; font-weight: 600; color: #475569; font-family: monospace;">{{ $certificate->verify_hash }}</td>
                </tr>
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b;">Kegiatan:</td>
                  <td style="padding: 6px 0; font-size: 12px; color: #334155;">{{ $event->title }}</td>
                </tr>
                @if($certificate->issued_at)
                <tr>
                  <td style="padding: 6px 0; font-size: 12px; color: #64748b;">Tanggal Terbit:</td>
                  <td style="padding: 6px 0; font-size: 12px; color: #334155;">{{ $certificate->issued_at->translatedFormat('d F Y, H:i') }} WIB</td>
                </tr>
                @endif
              </table>

              <table role="presentation" cellspacing="0" cellpadding="0" style="margin: 0 0 24px;">
                <tr>
                  <td style="border-radius: 10px; background-color: #03194a;">
                    <a href="{{ $portalUrl }}" target="_blank" style="display: inline-block; padding: 12px 28px; font-size: 14px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px;">
                      Buka Lemari Sertifikat di Web
                    </a>
                  </td>
                </tr>
              </table>

              <div style="background-color: #f0fdf4; border-left: 3px solid #16a34a; padding: 14px 16px; border-radius: 6px; margin: 0 0 20px;">
                <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #166534;">
                  <strong>Validitas Sertifikat:</strong> Dokumen E-Sertifikat Anda dilengkapi dengan kode verifikasi sah dan tercatat resmi dalam pangkalan data kegiatan Laboratorium ICT Universitas Budi Luhur.
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
