<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Kata Sandi</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f1f5f9; padding: 40px 16px;">
    <tr>
      <td align="center">
        <table role="presentation" width="100%" style="max-width: 560px; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
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
              <h2 style="margin: 0 0 16px; font-size: 18px; font-weight: 700; color: #03194a;">Atur Ulang Kata Sandi Anda</h2>
              <p style="margin: 0 0 16px; font-size: 14px; line-height: 1.6; color: #475569;">
                Halo <strong>{{ $user->name }}</strong>,
              </p>
              <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #475569;">
                Kami menerima permintaan untuk mengatur ulang kata sandi akun Eventict Anda. Klik tombol di bawah ini untuk memasukkan kata sandi baru.
              </p>
              <table role="presentation" cellspacing="0" cellpadding="0" style="margin: 0 0 28px;">
                <tr>
                  <td style="border-radius: 10px; background-color: #03194a;">
                    <a href="{{ $url }}" target="_blank" style="display: inline-block; padding: 12px 28px; font-size: 14px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px;">
                      Atur Ulang Kata Sandi
                    </a>
                  </td>
                </tr>
              </table>
              <div style="background-color: #f8fafc; border-left: 3px solid #03194a; padding: 14px 16px; border-radius: 6px; margin: 0 0 24px;">
                <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #64748b;">
                  Tautan ini hanya berlaku selama <strong>{{ $count }} menit</strong>. Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini dengan aman.
                </p>
              </div>
              <p style="margin: 0 0 8px; font-size: 12px; color: #94a3b8; line-height: 1.5;">
                Jika tombol di atas mengalami kendala, salin dan tempel alamat tautan berikut ke peramban web Anda:
              </p>
              <p style="margin: 0; font-size: 11px; word-break: break-all; color: #2563eb; line-height: 1.5;">
                <a href="{{ $url }}" style="color: #2563eb; text-decoration: underline;">{{ $url }}</a>
              </p>
            </td>
          </tr>
          <tr>
            <td style="background-color: #f8fafc; padding: 20px 32px; border-top: 1px solid #e2e8f0; text-align: center;">
              <p style="margin: 0; font-size: 11px; color: #94a3b8; line-height: 1.5;">
                Pemberitahuan otomatis dari Sistem Event & Sertifikasi Lab ICT Universitas Budi Luhur.
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
