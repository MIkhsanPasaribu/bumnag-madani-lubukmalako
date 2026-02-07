{{-- Sidebar untuk Sub Unit Usaha --}}
<aside class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transform transition-transform duration-200"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
    
    {{-- Overlay Mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 lg:hidden" x-cloak></div>
    
    {{-- Sidebar Content --}}
    <div class="relative h-full flex flex-col bg-white z-10">
        {{-- Logo & Brand --}}
        <div class="flex items-center gap-3 px-5 h-16 border-b border-gray-200">
            <img src="{{ $logoUrl }}" alt="Logo" class="w-10 h-10 object-contain">
            <div class="flex-1 min-w-0">
                <h2 class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->subUnitUsaha?->nama ?? 'Sub Unit' }}</h2>
                <p class="text-xs text-primary font-medium">{{ auth()->user()->unitUsaha?->nama ?? '' }}</p>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden p-1 rounded hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            {{-- Dashboard --}}
            <a href="{{ route('subunit.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('subunit.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('subunit.dashboard') ? 'text-white' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            {{-- Separator --}}
            <div class="pt-3 pb-1">
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Keuangan</p>
            </div>

            {{-- Laporan Keuangan --}}
            <a href="{{ route('subunit.laporan-keuangan.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('subunit.laporan-keuangan.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('subunit.laporan-keuangan.*') ? 'text-white' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Keuangan
            </a>

            {{-- Input Laporan --}}
            <a href="{{ route('subunit.laporan-keuangan.create') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('subunit.laporan-keuangan.create') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('subunit.laporan-keuangan.create') ? 'text-white' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Input Laporan
            </a>
        </nav>
        
        {{-- User Info --}}
        <div class="border-t border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-primary/10 rounded-full flex items-center justify-center">
                    <span class="text-primary font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</aside>
