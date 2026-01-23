<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - BUMNag Madani</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="flex min-h-screen">
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-bumnag-gray transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
            <div class="p-5 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag" class="h-10 w-auto">
                    <div>
                        <h1 class="font-bold text-white text-sm leading-tight">Admin Panel</h1>
                        <p class="text-xs text-gray-400">BUMNag Madani</p>
                    </div>
                </a>
            </div>
            
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-thin">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                
                <div class="pt-4">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Konten</p>
                    
                    <a href="{{ route('admin.profil.index') }}" class="admin-nav {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Profil BUMNag</span>
                    </a>
                    
                    <a href="{{ route('admin.berita.index') }}" class="admin-nav {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span>Berita</span>
                    </a>
                    
                    <a href="{{ route('admin.pengumuman.index') }}" class="admin-nav {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <span>Pengumuman</span>
                    </a>
                </div>
                
                <div class="pt-4">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Keuangan</p>
                    
                    <a href="{{ route('admin.keuangan.index') }}" class="admin-nav {{ request()->routeIs('admin.keuangan.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span>Laporan Keuangan</span>
                    </a>
                </div>
            </nav>
            
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-bumnag-olive rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-medium truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-gray-400 text-xs truncate">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-600/20 text-red-400 rounded-lg hover:bg-red-600/30 transition text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
            <header class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between px-4 lg:px-6 h-16">
                    <div class="flex items-center gap-4">
                        <button id="adminSidebarToggle" class="lg:hidden p-2 -ml-2 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        
                        <nav class="breadcrumb">
                            @yield('breadcrumb')
                        </nav>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <a href="{{ route('beranda') }}" target="_blank" class="text-sm text-gray-500 hover:text-bumnag-olive transition flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Lihat Website
                        </a>
                        <span class="text-sm text-gray-400">{{ now()->translatedFormat('l, d M Y') }}</span>
                    </div>
                </div>
            </header>
            
            <main class="flex-1 p-4 lg:p-6">
                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif
                
                @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <div id="adminSidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>
    
    <script>
        const adminSidebar = document.getElementById('adminSidebar');
        const adminSidebarToggle = document.getElementById('adminSidebarToggle');
        const adminSidebarOverlay = document.getElementById('adminSidebarOverlay');
        
        function toggleAdminSidebar() {
            adminSidebar.classList.toggle('-translate-x-full');
            adminSidebarOverlay.classList.toggle('hidden');
        }
        
        adminSidebarToggle?.addEventListener('click', toggleAdminSidebar);
        adminSidebarOverlay?.addEventListener('click', toggleAdminSidebar);
    </script>
    
    @stack('scripts')
</body>
</html>
