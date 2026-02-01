<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - BUMNag Madani Lubuk Malako</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-cream via-white to-primary/5" x-data="loginForm()">
    
    <div class="min-h-screen flex">
        {{-- Left Side - Branding (Hidden on Mobile) --}}
        <div class="hidden lg:flex lg:w-1/2 xl:w-2/5 bg-gradient-to-br from-primary to-primary-dark relative overflow-hidden">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>
            
            {{-- Decorative Circles --}}
            <div class="absolute -top-20 -left-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            
            {{-- Content --}}
            <div class="relative z-10 flex flex-col justify-center items-center p-12 text-white text-center">
                <div class="mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag Madani" class="h-28 w-auto mx-auto drop-shadow-xl">
                </div>
                <h1 class="text-3xl xl:text-4xl font-bold mb-4">BUMNag Madani</h1>
                <p class="text-lg xl:text-xl text-white/90 mb-2">Lubuk Malako</p>
                <div class="w-16 h-1 bg-white/40 rounded-full my-6"></div>
                <p class="text-white/80 max-w-md text-sm xl:text-base leading-relaxed">
                    Panel administrasi untuk mengelola informasi, berita, pengumuman, dan laporan keuangan BUMNag Madani Lubuk Malako.
                </p>
                
                {{-- Features --}}
                <div class="mt-10 grid grid-cols-2 gap-4 text-left max-w-sm">
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur rounded-lg p-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Kelola Berita</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur rounded-lg p-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Pengumuman</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur rounded-lg p-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Buku Kas</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur rounded-lg p-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Transparan</span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Right Side - Login Form --}}
        <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-12">
            <div class="w-full max-w-md">
                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ route('beranda') }}" class="inline-block">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag Madani" class="h-20 w-auto mx-auto mb-4">
                    </a>
                    <h1 class="text-xl font-bold text-gray-900">BUMNag Madani Lubuk Malako</h1>
                </div>
                
                {{-- Welcome Text --}}
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Selamat Datang!</h2>
                    <p class="text-gray-500">Silakan masuk ke panel administrasi</p>
                </div>
                
                {{-- Error Alert --}}
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3" 
                         x-data="{ show: true }" 
                         x-show="show"
                         x-transition>
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-red-800">Login Gagal</p>
                            <p class="text-sm text-red-600 mt-0.5">{{ $errors->first() }}</p>
                        </div>
                        <button @click="show = false" class="text-red-400 hover:text-red-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
                
                {{-- Login Form --}}
                <form action="{{ route('login') }}" method="POST" class="space-y-6" @submit="handleSubmit">
                    @csrf
                    
                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   x-model="form.email"
                                   @blur="validateEmail"
                                   :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500/20': errors.email }"
                                   class="form-input pl-12" 
                                   placeholder="admin@bumnagmadani.id"
                                   value="{{ old('email') }}"
                                   required 
                                   autofocus>
                            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <p x-show="errors.email" x-text="errors.email" class="mt-2 text-sm text-red-600"></p>
                    </div>
                    
                    {{-- Password Field --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   id="password" 
                                   name="password" 
                                   x-model="form.password"
                                   @blur="validatePassword"
                                   :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500/20': errors.password }"
                                   class="form-input pl-12 pr-12" 
                                   placeholder="••••••••"
                                   required>
                            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
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
                        <p x-show="errors.password" x-text="errors.password" class="mt-2 text-sm text-red-600"></p>
                    </div>
                    
                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" 
                                   id="remember" 
                                   name="remember" 
                                   x-model="form.remember"
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-offset-0 cursor-pointer"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2.5 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Ingat saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-primary-dark font-medium">
                            Lupa password?
                        </a>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit" 
                            :disabled="isSubmitting"
                            :class="{ 'opacity-75 cursor-not-allowed': isSubmitting }"
                            class="btn-primary w-full py-3 text-base font-semibold shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 transition-all">
                        <template x-if="!isSubmitting">
                            <span class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Masuk ke Dashboard
                            </span>
                        </template>
                        <template x-if="isSubmitting">
                            <span class="flex items-center justify-center">
                                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                        </template>
                    </button>
                </form>
                
                {{-- Divider --}}
                <div class="my-8 flex items-center">
                    <div class="flex-1 border-t border-gray-200"></div>
                    <span class="px-4 text-sm text-gray-400">atau</span>
                    <div class="flex-1 border-t border-gray-200"></div>
                </div>
                
                {{-- Back to Home --}}
                <a href="{{ route('beranda') }}" 
                   class="flex items-center justify-center gap-2 w-full py-3 px-4 border-2 border-gray-200 rounded-xl text-gray-600 font-medium hover:bg-gray-50 hover:border-gray-300 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Kembali ke Beranda
                </a>
                
                {{-- Footer --}}
                <p class="text-center text-xs text-gray-400 mt-8">
                    &copy; {{ date('Y') }} BUMNag Madani Lubuk Malako. Hak cipta dilindungi.
                </p>
            </div>
        </div>
    </div>
    
    <script>
        function loginForm() {
            return {
                showPassword: false,
                isSubmitting: false,
                form: {
                    email: '{{ old("email") }}',
                    password: '',
                    remember: {{ old('remember') ? 'true' : 'false' }}
                },
                errors: {
                    email: '',
                    password: ''
                },
                
                validateEmail() {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!this.form.email) {
                        this.errors.email = 'Email wajib diisi';
                    } else if (!emailRegex.test(this.form.email)) {
                        this.errors.email = 'Format email tidak valid';
                    } else {
                        this.errors.email = '';
                    }
                },
                
                validatePassword() {
                    if (!this.form.password) {
                        this.errors.password = 'Password wajib diisi';
                    } else if (this.form.password.length < 6) {
                        this.errors.password = 'Password minimal 6 karakter';
                    } else {
                        this.errors.password = '';
                    }
                },
                
                handleSubmit(e) {
                    this.validateEmail();
                    this.validatePassword();
                    
                    if (this.errors.email || this.errors.password) {
                        e.preventDefault();
                        return false;
                    }
                    
                    this.isSubmitting = true;
                }
            }
        }
    </script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
