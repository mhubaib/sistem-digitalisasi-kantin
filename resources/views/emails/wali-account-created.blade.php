<!DOCTYPE html>
<html>
<head>
    <title>Akun Wali Santri</title>
</head>
<body>
    <h1>Akun Wali Santri Telah Dibuat</h1>
    
    <p>Halo {{ $waliUser->name }},</p>
    
    <p>Anda telah didaftarkan sebagai wali santri untuk {{ $santriName }}.</p>
    
    <p>Berikut adalah informasi login Anda:</p>
    
    <ul>
        <li><strong>Email:</strong> {{ $waliUser->email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    
    <p>Silakan login menggunakan informasi di atas melalui link berikut:</p>
    
    <p><a href="{{ url('/login') }}">Login ke Sistem</a></p>
    
    <p>Harap segera ubah password Anda setelah login pertama kali.</p>
    
    <p>Terima kasih,<br>Tim Koperasi Digital Pondok</p>
</body>
</html>