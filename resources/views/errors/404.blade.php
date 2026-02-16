<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | BUMNag Madani</title>
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
            <circle cx="60" cy="60" r="56" stroke="#86ae5f" stroke-width="3" fill="#f0fdf4"/>
            <path d="M40 75 C40 75 48 60 60 60 C72 60 80 75 80 75" stroke="#374151" stroke-width="3" stroke-linecap="round" fill="none"/>
            <circle cx="46" cy="48" r="4" fill="#374151"/>
            <circle cx="74" cy="48" r="4" fill="#374151"/>
            <path d="M35 85h50" stroke="#86ae5f" stroke-width="2" stroke-linecap="round" stroke-dasharray="4 4"/>
            <text x="60" y="105" text-anchor="middle" font-size="12" fill="#6b7280" font-family="system-ui">Halaman tidak ditemukan</text>
        </svg>
        
        <div class="error-code">404</div>
        <h1 class="error-title">Halaman Tidak Ditemukan</h1>
        <p class="error-desc">
            Maaf, halaman yang Anda cari tidak ditemukan atau mungkin telah dipindahkan. 
            Pastikan alamat URL sudah benar.
        </p>
        
        <div>
            <a href="/" class="btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Kembali ke Beranda
            </a>
            <a href="javascript:history.back()" class="btn btn-outline">Kembali</a>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} BUMNag Madani Lubuk Malako
        </div>
    </div>
</body>
</html>
