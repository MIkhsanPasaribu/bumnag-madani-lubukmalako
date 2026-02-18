<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin BUMNag Madani</title>
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen" x-data="{ sidebarOpen: false }">
    
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')
        
        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen lg:ml-64">
            {{-- Top Bar --}}
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 sm:px-6 h-16">
                    {{-- Mobile Menu Button --}}
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    {{-- Page Title --}}
                    <h1 class="text-lg font-semibold text-gray-900 hidden sm:block">@yield('page_title', 'Dashboard')</h1>
                    
                    {{-- Right Actions --}}
                    <div class="flex items-center gap-4">
                        {{-- View Site --}}
                        <a href="{{ route('beranda') }}" target="_blank" class="text-sm text-gray-600 hover:text-primary hidden sm:flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Lihat Website
                        </a>
                        
                        {{-- User Dropdown --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 hover:bg-gray-100 rounded-lg px-3 py-2">
                                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                                    <span class="text-primary font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <div x-show="open" 
                                 x-cloak
                                 @click.outside="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('admin.password.edit') }}" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    Ganti Password
                                </a>
                                <a href="{{ route('admin.security.edit') }}" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Pertanyaan Keamanan
                                </a>
                                <div class="border-t border-gray-100 mt-1"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            {{-- Page Content --}}
            <main class="flex-1 p-4 sm:p-6">
                {{-- Page Header --}}
                @hasSection('header')
                    <div class="mb-6">
                        @yield('header')
                    </div>
                @endif
                
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mb-6">
                        @include('components.alert', ['type' => 'success', 'message' => session('success')])
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6">
                        @include('components.alert', ['type' => 'danger', 'message' => session('error')])
                    </div>
                @endif
                
                @yield('content')
            </main>
            
            {{-- Footer --}}
            <footer class="bg-white border-t border-gray-200 py-4 px-6">
                <p class="text-sm text-gray-500 text-center">
                    &copy; {{ date('Y') }} BUMNag Madani Lubuk Malako. Panel Administrasi.
                </p>
            </footer>
        </div>
    </div>
    
    {{-- Loading Overlay --}}
    <div id="loading-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl p-8 shadow-2xl flex flex-col items-center gap-4">
            <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            <span class="text-gray-600 font-medium">Memuat...</span>
        </div>
    </div>
    
    {{-- jQuery (Required for Summernote) — harus tanpa defer agar tersedia sebelum Summernote JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    @stack('scripts')
</body>
</html>
