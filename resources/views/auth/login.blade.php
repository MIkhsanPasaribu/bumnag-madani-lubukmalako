<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - BUMNag Madani Lubuk Malako</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('beranda') }}" class="inline-flex items-center gap-3 mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag" class="h-16 w-auto">
            </a>
            <h1 class="text-2xl font-bold text-bumnag-gray">Login Admin</h1>
            <p class="text-gray-500 text-sm mt-1">BUMNag Madani Lubuk Malako</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="form-input" 
                        placeholder="admin@bumnagmadani.id"
                        required 
                        autofocus
                    >
                </div>
                
                <div>
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Masukkan password"
                        required
                    >
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-bumnag-olive border-gray-300 rounded focus:ring-bumnag-olive">
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>
                
                <button type="submit" class="btn-primary w-full py-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Masuk
                </button>
            </form>
        </div>
        
        <p class="text-center text-sm text-gray-500 mt-6">
            <a href="{{ route('beranda') }}" class="text-bumnag-olive hover:underline flex items-center justify-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </p>
    </div>
</body>
</html>
