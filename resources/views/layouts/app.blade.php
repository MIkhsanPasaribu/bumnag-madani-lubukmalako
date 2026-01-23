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
<body class="min-h-screen">
    <div class="flex min-h-screen">
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 lg:w-72 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
            <div class="p-4 lg:p-5 border-b border-gray-100">
                <a href="{{ route('beranda') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag" class="h-10 lg:h-12 w-auto">
                    <div class="min-w-0">
                        <h1 class="font-bold text-bumnag-olive text-sm lg:text-base leading-tight truncate">BUMNag Madani</h1>
                        <p class="text-xs text-gray-500 truncate">Lubuk Malako</p>
                    </div>
                </a>
            </div>
            
            <nav class="flex-1 p-3 lg:p-4 space-y-1 overflow-y-auto scrollbar-thin">
                <a href="{{ route('beranda') }}" class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                
                <a href="{{ route('profil') }}" class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Profil BUMNag</span>
                </a>
                
                <div class="pt-4">
                    <p class="px-4 text-[10px] lg:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Keuangan</p>
                    <a href="{{ route('keuangan.statistik') }}" class="nav-link {{ request()->routeIs('keuangan.statistik') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Statistik Laporan</span>
                    </a>
                    <a href="{{ route('keuangan.transparansi') }}" class="nav-link {{ request()->routeIs('keuangan.transparansi') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Transparansi</span>
                    </a>
                </div>
                
                <div class="pt-4">
                    <p class="px-4 text-[10px] lg:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Informasi</p>
                    <a href="{{ route('berita.index') }}" class="nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span>Berita</span>
                    </a>
                    <a href="{{ route('pengumuman') }}" class="nav-link {{ request()->routeIs('pengumuman') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <span>Pengumuman</span>
                    </a>
                </div>
            </nav>
            
            <div class="p-3 lg:p-4 border-t border-gray-100">
                <div class="bg-gradient-to-br from-bumnag-olive/10 to-bumnag-olive/5 rounded-xl p-3 lg:p-4">
                    <p class="text-xs lg:text-sm font-medium text-bumnag-olive">Hubungi Kami</p>
                    <p class="text-[10px] lg:text-xs text-gray-500 mt-1 truncate">info@bumnagmadani.id</p>
                </div>
            </div>
        </aside>
        
        <div class="flex-1 lg:ml-72 flex flex-col min-h-screen">
            <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
                <div class="flex items-center justify-between px-4 lg:px-6 h-14 lg:h-16">
                    <div class="flex items-center gap-3">
                        <button id="sidebarToggle" class="lg:hidden p-2 -ml-2 rounded-lg hover:bg-gray-100 active:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h2 class="text-base lg:text-lg font-semibold text-bumnag-gray truncate">@yield('page-title', 'Beranda')</h2>
                    </div>
                    
                    <div class="flex items-center gap-2 lg:gap-4">
                        <span class="hidden sm:block text-xs lg:text-sm text-gray-500">{{ now()->translatedFormat('l, d M Y') }}</span>
                    </div>
                </div>
            </header>
            
            <main class="flex-1 p-4 lg:p-6 xl:p-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
            
            <footer class="border-t border-gray-200 bg-white mt-auto">
                <div class="px-4 lg:px-6 py-4 lg:py-6">
                    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 lg:h-10">
                            <div>
                                <p class="font-semibold text-bumnag-olive text-sm lg:text-base">BUMNag Madani</p>
                                <p class="text-[10px] lg:text-xs text-gray-500">Lubuk Malako</p>
                            </div>
                        </div>
                        <p class="text-[10px] lg:text-xs text-gray-500 text-center sm:text-right">&copy; {{ date('Y') }} BUMNag Madani Lubuk Malako</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity"></div>
    
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
        
        sidebarToggle?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', toggleSidebar);
        
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
