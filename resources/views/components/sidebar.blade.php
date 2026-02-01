{{-- Admin Sidebar Component --}}

{{-- Mobile Overlay --}}
<div x-show="sidebarOpen" 
     x-cloak
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-40 lg:hidden">
</div>

{{-- Sidebar --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 w-64 bg-gray-900 z-50 transition-transform duration-300 lg:translate-x-0">
    
    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 h-16 border-b border-gray-800">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
        <div>
            <h2 class="text-white font-bold text-sm">BUMNag Madani</h2>
            <p class="text-gray-400 text-xs">Admin Panel</p>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden ml-auto text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    {{-- Navigation --}}
    <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-primary' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Dashboard
        </a>
        
        {{-- Section: Konten --}}
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Konten</p>
            
            {{-- Berita --}}
            <a href="{{ route('admin.berita.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.berita.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Kelola Berita
            </a>
            
            {{-- Pengumuman --}}
            <a href="{{ route('admin.pengumuman.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.pengumuman.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                Kelola Pengumuman
            </a>
        </div>
        
        {{-- Section: Keuangan --}}
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Keuangan</p>
            
            {{-- Transaksi Kas / Buku Kas --}}
            <a href="{{ route('admin.transaksi-kas.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.transaksi-kas.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Buku Kas Harian
            </a>
        </div>
        
        {{-- Section: Pengaturan --}}
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pengaturan</p>
            
            {{-- Profil BUMNag --}}
            <a href="{{ route('admin.profil.edit') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.profil.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Profil BUMNag
            </a>
        </div>
    </nav>
</aside>
