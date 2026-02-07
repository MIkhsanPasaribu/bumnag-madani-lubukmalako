<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Website resmi Badan Usaha Milik Nagari (BUMNag) Madani Lubuk Malako, Kec. Sangir Jujuan, Kab. Solok Selatan')">
    <meta name="keywords" content="BUMNag, Madani, Lubuk Malako, Nagari, Solok Selatan, Sangir Jujuan">
    <meta name="author" content="BUMNag Madani Lubuk Malako">
    
    <title>@yield('title', 'Beranda') - BUMNag Madani Lubuk Malako</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="bg-cream min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">
    
    <!-- Navbar -->
    @include('components.navbar')
    
    <!-- Main Content -->
    <main class="flex-1">
        <!-- Breadcrumb (tampil di semua halaman kecuali beranda) -->
        @if(!request()->routeIs('beranda'))
            <div class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                    @include('components.breadcrumb')
                </div>
            </div>
        @endif
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                @include('components.alert', ['type' => 'success', 'message' => session('success')])
            </div>
        @endif
        
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                @include('components.alert', ['type' => 'danger', 'message' => session('error')])
            </div>
        @endif
        
        <!-- Page Content -->
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('components.footer')
    
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl p-8 shadow-2xl flex flex-col items-center gap-4">
            <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            <span class="text-gray-600 font-medium">Memuat...</span>
        </div>
    </div>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
