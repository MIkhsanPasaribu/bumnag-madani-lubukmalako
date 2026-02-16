<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>429 - Terlalu Banyak Permintaan | BUMNag Madani</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #fffaed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .container {
            max-width: 540px;
            width: 100%;
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 3rem 2rem;
            text-align: center;
        }
        .logo { height: 48px; margin-bottom: 1.5rem; }
        .icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
        }
        .error-code {
            font-size: 4rem;
            font-weight: 800;
            color: #b71e42;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
        }
        .error-desc {
            color: #6b7280;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: #86ae5f;
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn:hover { background: #6b9a45; }
        .btn-outline {
            background: transparent;
            color: #86ae5f;
            border: 2px solid #86ae5f;
            margin-left: 0.5rem;
        }
        .btn-outline:hover { background: #86ae5f; color: #fff; }
        .footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f3f4f6;
            color: #9ca3af;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="/images/logo.png" alt="Logo BUMNag" class="logo">
        
        <svg class="icon" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="60" cy="60" r="56" stroke="#ef4444" stroke-width="3" fill="#fef2f2"/>
            <path d="M60 30v40" stroke="#ef4444" stroke-width="4" stroke-linecap="round"/>
            <path d="M40 50l20-20 20 20" stroke="#ef4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <path d="M40 65l20-20 20 20" stroke="#ef4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" opacity="0.5"/>
            <path d="M40 80l20-20 20 20" stroke="#ef4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" opacity="0.25"/>
            <circle cx="60" cy="95" r="3" fill="#ef4444"/>
        </svg>
        
        <div class="error-code">429</div>
        <h1 class="error-title">Terlalu Banyak Permintaan</h1>
        <p class="error-desc">
            Anda telah mengirim terlalu banyak permintaan dalam waktu singkat. 
            Silakan tunggu beberapa saat dan coba lagi.
        </p>
        
        <div>
            <a href="javascript:setTimeout(()=>location.reload(), 3000)" class="btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"/>
                    <path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/>
                </svg>
                Coba Lagi
            </a>
            <a href="/" class="btn btn-outline">Ke Beranda</a>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} BUMNag Madani Lubuk Malako
        </div>
    </div>
</body>
</html>
