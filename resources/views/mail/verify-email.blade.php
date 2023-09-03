<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email Anda</title>
</head>

<body>
    <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#f2f2f2">
        <tr>
            <td>
                <table align="center" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">

                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="60%">
                                        <h1>Verifikasi Email Anda</h1>
                                        <p>Selamat datangs di situs kami! Kami sangat senang Anda bergabung dengan kami.
                                            Untuk melanjutkan, Anda perlu memverifikasi alamat email Anda.</p>
                                    </td>
                                    <td align="right">
                                        <img src="https://example.com/logo.png" alt="Logo" width="100">
                                    </td>
                                </tr>
                            </table>

                            <p>Silakan klik tombol di bawah ini untuk melakukan verifikasi email Anda:</p>
                            <p><a href="{{ route('verification.verify',['user' => $user->id]) }}"
                                    style="background-color: #007BFF; color: #ffffff; display: inline-block; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Verifikasi
                                    Email</a></p>

                            <p>Jika Anda tidak membuat akun di situs kami, Anda bisa mengabaikan email ini.</p>

                            <p>Terima kasih,<br>Nama Tim Anda</p>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>