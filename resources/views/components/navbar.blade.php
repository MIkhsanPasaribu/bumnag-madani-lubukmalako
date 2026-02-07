{{-- Navbar Component - Horizontal Sticky Navigation for Public Pages --}}
<header class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-40 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">
            
            {{-- Logo --}}
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
                <img src="{{ $logoUrl }}" alt="Logo BUMNag Madani" class="h-10 md:h-12 w-auto transition-transform group-hover:scale-105">
                <div class="hidden sm:block">
                    <h1 class="text-lg md:text-xl font-bold text-gray-900 leading-tight">BUMNag Madani</h1>
                    <p class="text-xs text-gray-500">Lubuk Malako</p>
                </div>
            </a>
            
            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center gap-1">
                <a href="{{ route('beranda') }}" 
                   class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('profil') }}" 
                   class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                    Profil
                </a>
                <a href="{{ route('statistik') }}" 
                   class="nav-link {{ request()->routeIs('statistik') || request()->routeIs('statistik.*') ? 'active' : '' }}">
                    Statistik
                </a>
                <a href="{{ route('transparansi') }}" 
                   class="nav-link {{ request()->routeIs('transparansi') ? 'active' : '' }}">
                    Transparansi
                </a>
                <a href="{{ route('berita.index') }}" 
                   class="nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}">
                    Berita
                </a>
                <a href="{{ route('laporan-tahunan.index') }}" 
                   class="nav-link {{ request()->routeIs('laporan-tahunan.*') ? 'active' : '' }}">
                    Laporan Tahunan
                </a>
                <a href="{{ route('hubungi-kami') }}" 
                   class="nav-link {{ request()->routeIs('hubungi-kami') ? 'active' : '' }}">
                    Hubungi Kami
                </a>
            </nav>
            
            {{-- Login Button (Desktop) --}}
            <div class="hidden lg:flex items-center gap-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login Admin
                    </a>
                @endauth
            </div>
            
            {{-- Mobile Menu Button --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
                    aria-label="Toggle menu">
                <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    
    {{-- Mobile Navigation --}}
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
            <a href="{{ route('beranda') }}" 
               class="block px-4 py-3 rounded-lg {{ request()->routeIs('beranda') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                Beranda
            </a>
            <a href="{{ route('profil') }}" 
               class="block px-4 py-3 rounded-lg {{ request()->routeIs('profil') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                Profil BUMNag
            </a>
            <a href="{{ route('statistik') }}" 
               class="block px-4 py-3 rounded-lg {{ request()->routeIs('statistik') || request()->routeIs('statistik.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                Statistik Keuangan
            </a>
            <a href="{{ route('transparansi') }}" 
               class="block px-4 py-3 rounded-lg {{ request()->routeIs('transparansi') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                Transparansi
            </a>
            <a href="{{ route('berita.index') }}" 
               class="block px-4 py-3 rounded-lg {{ request()->routeIs('berita.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                Berita
            </a>
            <a href="{{ route('laporan-tahunan.index') }}" 
               class="block px-4 py-3 rounded-lg {{ request()->routeIs('laporan-tahunan.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                Laporan Tahunan
            </a>
            <a href="{{ route('hubungi-kami') }}" 
               class="block px-4 py-3 rounded-lg {{ request()->routeIs('hubungi-kami') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                Hubungi Kami
            </a>
            
            <div class="pt-4 border-t border-gray-100">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

<style>
    [x-cloak] { display: none !important; }
</style>
