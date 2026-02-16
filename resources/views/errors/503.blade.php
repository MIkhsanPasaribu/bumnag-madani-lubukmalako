<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Sedang Pemeliharaan | BUMNag Madani</title>
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
            color: #f59e0b;
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
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #f3f4f6;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #86ae5f, #a5c285);
            border-radius: 3px;
            animation: loading 2s ease-in-out infinite;
            width: 40%;
        }
        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(350%); }
        }
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
            <circle cx="60" cy="60" r="56" stroke="#f59e0b" stroke-width="3" fill="#fffbeb"/>
            <circle cx="60" cy="55" r="18" stroke="#f59e0b" stroke-width="2.5" fill="none"/>
            <path d="M60 37v18l12 8" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M44 82l-6 6M76 82l6 6" stroke="#374151" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M38 88l44 0" stroke="#374151" stroke-width="2" stroke-linecap="round" opacity="0.3"/>
            <circle cx="40" cy="95" r="3" fill="#86ae5f" opacity="0.5"/>
            <circle cx="60" cy="95" r="3" fill="#86ae5f" opacity="0.7"/>
            <circle cx="80" cy="95" r="3" fill="#86ae5f"/>
        </svg>
        
        <div class="error-code">503</div>
        <h1 class="error-title">Sedang Pemeliharaan</h1>
        <p class="error-desc">
            Website sedang dalam proses pemeliharaan untuk meningkatkan kualitas layanan. 
            Kami akan segera kembali. Terima kasih atas kesabaran Anda.
        </p>
        
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
        
        <a href="javascript:location.reload()" class="btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"/>
                <path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/>
            </svg>
            Coba Lagi
        </a>
        
        <div class="footer">
            &copy; {{ date('Y') }} BUMNag Madani Lubuk Malako
        </div>
    </div>
</body>
</html>
