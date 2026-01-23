<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BUMNag Madani Lubuk Malako - Badan Usaha Milik Nagari">
    <title>@yield('title', 'BUMNag Madani Lubuk Malako')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen flex flex-col">
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="{{ route('beranda') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag" class="h-10 lg:h-12 w-auto">
                    <div class="hidden sm:block">
                        <h1 class="font-bold text-bumnag-olive text-sm lg:text-base leading-tight">BUMNag Madani</h1>
                        <p class="text-xs text-gray-500">Lubuk Malako</p>
                    </div>
                </a>
                
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('beranda') }}" class="nav-top {{ request()->routeIs('beranda') ? 'active' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('profil') }}" class="nav-top {{ request()->routeIs('profil') ? 'active' : '' }}">
                        Profil
                    </a>
                    <div class="relative group">
                        <button class="nav-top flex items-center gap-1 {{ request()->routeIs('keuangan.*') ? 'active' : '' }}">
                            Keuangan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('keuangan.statistik') }}" class="dropdown-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Statistik Laporan
                            </a>
                            <a href="{{ route('keuangan.transparansi') }}" class="dropdown-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Transparansi
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('berita.index') }}" class="nav-top {{ request()->routeIs('berita.*') ? 'active' : '' }}">
                        Berita
                    </a>
                    <a href="{{ route('pengumuman') }}" class="nav-top {{ request()->routeIs('pengumuman') ? 'active' : '' }}">
                        Pengumuman
                    </a>
                </nav>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="btn-primary text-sm py-2 px-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Login Admin</span>
                    </a>
                    
                    <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <div id="mobileMenu" class="lg:hidden hidden border-t border-gray-100">
            <nav class="max-w-7xl mx-auto px-4 py-4 space-y-2">
                <a href="{{ route('beranda') }}" class="mobile-nav {{ request()->routeIs('beranda') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('profil') }}" class="mobile-nav {{ request()->routeIs('profil') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Profil BUMNag
                </a>
                <a href="{{ route('keuangan.statistik') }}" class="mobile-nav {{ request()->routeIs('keuangan.statistik') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Statistik Laporan
                </a>
                <a href="{{ route('keuangan.transparansi') }}" class="mobile-nav {{ request()->routeIs('keuangan.transparansi') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Transparansi
                </a>
                <a href="{{ route('berita.index') }}" class="mobile-nav {{ request()->routeIs('berita.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    Berita
                </a>
                <a href="{{ route('pengumuman') }}" class="mobile-nav {{ request()->routeIs('pengumuman') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    Pengumuman
                </a>
            </nav>
        </div>
    </header>
    
    @hasSection('breadcrumb')
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            @yield('breadcrumb')
        </div>
    </div>
    @endif
    
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
            @yield('content')
        </div>
    </main>
    
    <footer class="bg-bumnag-gray text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                        <div>
                            <h3 class="font-bold text-lg">BUMNag Madani</h3>
                            <p class="text-gray-400 text-sm">Lubuk Malako</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-md">
                        Badan Usaha Milik Nagari yang berkomitmen untuk memajukan perekonomian masyarakat nagari melalui pengelolaan usaha yang profesional dan berkelanjutan.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('beranda') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('profil') }}" class="hover:text-white transition">Profil BUMNag</a></li>
                        <li><a href="{{ route('keuangan.statistik') }}" class="hover:text-white transition">Statistik Keuangan</a></li>
                        <li><a href="{{ route('berita.index') }}" class="hover:text-white transition">Berita</a></li>
                        <li><a href="{{ route('pengumuman') }}" class="hover:text-white transition">Pengumuman</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Lubuk Malako, Kab. Solok Selatan, Sumatera Barat</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:info@bumnagmadani.id" class="hover:text-white transition">info@bumnagmadani.id</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>(0755) 123456</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} BUMNag Madani Lubuk Malako. All rights reserved.</p>
                <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Admin Area
                </a>
            </div>
        </div>
    </footer>
    
    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        mobileMenuBtn?.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    
    @stack('scripts')
</body>
</html>
