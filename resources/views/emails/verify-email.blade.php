<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Potvrdi email adresu</title>
</head>
<body style="margin:0; padding:0; background:#f5f7fb; color:#172033; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f7fb; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px; background:#ffffff; border:1px solid #e4e9f1; border-radius:24px; overflow:hidden; box-shadow:0 16px 40px rgba(31,43,71,0.08);">
                    <tr>
                        <td style="padding:28px 28px 0;">
                            <div style="display:inline-block; padding:8px 12px; border-radius:999px; background:#eeedff; color:#625df5; font-size:12px; font-weight:700; letter-spacing:0.02em;">
                                {{ $appName }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 28px 0;">
                            <h1 style="margin:0; font-size:30px; line-height:1.1; letter-spacing:-0.04em; color:#172033;">
                                Potvrdi svoju email adresu
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 28px 0;">
                            <p style="margin:0; font-size:15px; line-height:1.7; color:#6f7b91;">
                                Bok {{ $notifiable->name }}, samo još jedan korak dijeli te od aktivnog računa. Klikni gumb ispod i potvrdi da je ova email adresa stvarno tvoja.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 28px 0;">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="border-radius:14px; background:#625df5;">
                                        <a href="{{ $url }}" style="display:inline-block; padding:14px 22px; color:#ffffff; text-decoration:none; font-size:14px; font-weight:700; border-radius:14px;">
                                            Potvrdi email adresu
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:22px 28px 0;">
                            <p style="margin:0; font-size:13px; line-height:1.7; color:#6f7b91;">
                                Nakon potvrde možeš se prijaviti i pristupiti svom DocuPocket trezoru. Ako se nisi registrirao, možeš sigurno zanemariti ovu poruku.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 28px 28px;">
                            <p style="margin:0; font-size:12px; line-height:1.7; color:#8a93a8; word-break:break-all;">
                                Ako gumb ne radi, kopiraj i otvori ovu poveznicu:<br>
                                <a href="{{ $url }}" style="color:#625df5; text-decoration:none;">{{ $url }}</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
