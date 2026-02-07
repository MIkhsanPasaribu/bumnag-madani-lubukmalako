<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - BUMNag Madani Lubuk Malako</title>
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-cream via-white to-primary/5" x-data="resetPasswordForm()">
    
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="{{ route('beranda') }}" class="inline-block">
                    <img src="{{ $logoUrl }}" alt="Logo BUMNag Madani" class="h-20 w-auto mx-auto mb-4">
                </a>
                <h1 class="text-xl font-bold text-gray-900">BUMNag Madani Lubuk Malako</h1>
            </div>
            
            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow-lg p-8">
                {{-- Progress Steps --}}
                <div class="flex items-center justify-center gap-2 mb-8">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="ml-2 text-sm text-gray-500">Email</span>
                    </div>
                    <div class="w-8 h-px bg-primary"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="ml-2 text-sm text-gray-500">Verifikasi</span>
                    </div>
                    <div class="w-8 h-px bg-primary"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Reset</span>
                    </div>
                </div>
                
                {{-- Header --}}
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Buat Password Baru</h2>
                    <p class="text-gray-500 text-sm">Masukkan password baru untuk akun Anda.</p>
                </div>
                
                {{-- User Email Info --}}
                <div class="mb-6 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-green-600">Identitas terverifikasi</p>
                        <p class="font-medium text-green-900">{{ $email }}</p>
                    </div>
                </div>
                
                {{-- Error Alert --}}
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-red-800">Gagal</p>
                            <p class="text-sm text-red-600 mt-0.5">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif
                
                {{-- Form --}}
                <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    {{-- Password Field --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   id="password" 
                                   name="password" 
                                   class="form-input pr-12" 
                                   placeholder="Minimal 8 karakter"
                                   required
                                   autofocus>
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Confirm Password Field --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input :type="showConfirmPassword ? 'text' : 'password'" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="form-input pr-12" 
                                   placeholder="Ulangi password baru"
                                   required>
                            <button type="button" 
                                    @click="showConfirmPassword = !showConfirmPassword" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showConfirmPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Password Requirements --}}
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-2">Ketentuan Password:</p>
                        <ul class="text-sm text-gray-500 space-y-1">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Minimal 8 karakter
                            </li>
                        </ul>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full btn-primary py-3 text-base font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Reset Password
                    </button>
                </form>
                
                {{-- Back to Login --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-primary hover:text-primary-dark font-medium inline-flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Login
                    </a>
                </div>
            </div>
            
            {{-- Footer --}}
            <p class="text-center text-sm text-gray-500 mt-8">
                &copy; {{ date('Y') }} BUMNag Madani Lubuk Malako
            </p>
        </div>
    </div>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    <script>
        function resetPasswordForm() {
            return {
                showPassword: false,
                showConfirmPassword: false
            }
        }
    </script>
    
</body>
</html>
