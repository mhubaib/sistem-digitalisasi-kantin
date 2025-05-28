<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Santri Disetujui</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3a5f 100%);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }
        
        .header-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 15px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px;
        }
        
        .greeting {
            font-size: 18px;
            font-weight: 500;
            color: #2c5aa0;
            margin-bottom: 20px;
        }
        
        .message {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
            color: #555555;
        }
        
        .cta-container {
            text-align: center;
            margin: 30px 0;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #2c5aa0;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .info-box h3 {
            font-size: 16px;
            color: #2c5aa0;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .info-box p {
            color: #666666;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .footer {
            background-color: #f8f9fa;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .footer p {
            color: #666666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #2c5aa0;
            text-decoration: none;
            font-size: 12px;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e9ecef, transparent);
            margin: 25px 0;
        }
        
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .header, .content, .footer {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .cta-button {
                padding: 12px 25px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1>Akun Berhasil Disetujui</h1>
            <p>Selamat! Akun Anda telah diaktifkan</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Assalamu'alaikum {{ $user->name }},
            </div>
            
            <div class="message">
                Alhamdulillah, kami dengan senang hati memberitahukan bahwa akun anda telah <strong>berhasil disetujui</strong> oleh tim admin kami. Sekarang Anda dapat mengakses seluruh fitur platform dengan menggunakan email dan password yang telah Anda daftarkan.
            </div>
            
            <div class="info-box">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 8px;">
                        <path d="M13 16H12V12H11M12 8H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#2c5aa0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Informasi Penting
                </h3>
                <p>Pastikan untuk menjaga kerahasiaan akun Anda dan jangan berbagi informasi login dengan orang lain. Jika mengalami kesulitan dalam mengakses akun, silakan hubungi tim support kami.</p>
            </div>
            
            <div class="cta-container">
                <a href="{{ route('auth.login') }}" class="cta-button">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-right: 8px;">
                        <path d="M15 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H15M10 17L15 12L10 7M21 12H3" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Masuk ke Akun Saya
                </a>
            </div>
            
            <div class="divider"></div>
            
            <div class="message" style="margin-bottom: 10px; font-size: 14px; color: #666;">
                Barakallahu fiikum atas kepercayaan Anda bergabung dengan platform kami. Semoga bermanfaat untuk aktivitas keuangan anda.
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>Tim Admin Platform Santri</strong></p>
            <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
            
            <div class="social-links">
                <a href="#">Bantuan</a> | 
                <a href="#">Kontak</a> | 
                <a href="#">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</body>
</html>