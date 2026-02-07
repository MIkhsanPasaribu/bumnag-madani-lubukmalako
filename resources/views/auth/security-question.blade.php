<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pertanyaan Keamanan - BUMNag Madani Lubuk Malako</title>
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-cream via-white to-primary/5">
    
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
                    <div class="w-8 h-px bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Verifikasi</span>
                    </div>
                    <div class="w-8 h-px bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                        <span class="ml-2 text-sm text-gray-500">Reset</span>
                    </div>
                </div>
                
                {{-- Header --}}
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Pertanyaan Keamanan</h2>
                    <p class="text-gray-500 text-sm">Jawab pertanyaan keamanan untuk melanjutkan reset password.</p>
                </div>
                
                {{-- User Email Info --}}
                <div class="mb-6 p-3 bg-gray-50 rounded-lg flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-900">{{ $email }}</p>
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
                <form action="{{ route('password.verify.answer') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    {{-- Security Question --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pertanyaan Keamanan
                        </label>
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                            <p class="font-medium text-amber-900">{{ $question }}</p>
                        </div>
                    </div>
                    
                    {{-- Security Answer --}}
                    <div>
                        <label for="security_answer" class="block text-sm font-medium text-gray-700 mb-2">
                            Jawaban Anda
                        </label>
                        <input type="text" 
                               id="security_answer" 
                               name="security_answer" 
                               class="form-input" 
                               placeholder="Ketik jawaban Anda..."
                               value="{{ old('security_answer') }}"
                               required 
                               autofocus
                               autocomplete="off">
                        <p class="mt-1.5 text-xs text-gray-500">* Jawaban tidak case-sensitive</p>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full btn-primary py-3 text-base font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Verifikasi
                    </button>
                </form>
                
                {{-- Back to Login --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-primary-dark font-medium inline-flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
            
            {{-- Footer --}}
            <p class="text-center text-sm text-gray-500 mt-8">
                &copy; {{ date('Y') }} BUMNag Madani Lubuk Malako
            </p>
        </div>
    </div>
    
</body>
</html>
