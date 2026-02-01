@extends('layouts.admin')

@section('title', 'Pertanyaan Keamanan')

@section('content')
<div class="p-6">
    {{-- Breadcrumb --}}
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
        ['label' => 'Pertanyaan Keamanan']
    ]" />
    
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Pertanyaan Keamanan</h1>
        <p class="text-gray-500 mt-1">Atur pertanyaan keamanan untuk pemulihan password</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Form Card --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-green-800">Berhasil!</p>
                            <p class="text-sm text-green-600 mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                
                {{-- Error Messages --}}
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-red-800">Terjadi Kesalahan</p>
                            <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                
                {{-- Current Status --}}
                @if(auth()->user()->hasSecurityQuestion())
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-blue-800">Pertanyaan Saat Ini</p>
                            <p class="text-sm text-blue-600 mt-0.5">{{ $securityQuestions[auth()->user()->security_question] ?? 'Tidak diketahui' }}</p>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('admin.security.update') }}" method="POST" class="space-y-6" x-data="{ showPassword: false }">
                    @csrf
                    @method('PUT')
                    
                    {{-- Security Question --}}
                    <div>
                        <label for="security_question" class="block text-sm font-medium text-gray-700 mb-2">
                            Pertanyaan Keamanan <span class="text-red-500">*</span>
                        </label>
                        <select id="security_question" 
                                name="security_question" 
                                class="form-input" 
                                required>
                            <option value="">Pilih pertanyaan keamanan</option>
                            @foreach($securityQuestions as $key => $question)
                                <option value="{{ $key }}" {{ old('security_question', auth()->user()->security_question) == $key ? 'selected' : '' }}>
                                    {{ $question }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- Security Answer --}}
                    <div>
                        <label for="security_answer" class="block text-sm font-medium text-gray-700 mb-2">
                            Jawaban <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="security_answer" 
                               name="security_answer" 
                               class="form-input" 
                               placeholder="Masukkan jawaban Anda"
                               required>
                        <p class="mt-2 text-xs text-gray-500">Jawaban tidak case-sensitive (huruf besar/kecil dianggap sama)</p>
                    </div>
                    
                    {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   id="current_password" 
                                   name="current_password" 
                                   class="form-input pr-12" 
                                   placeholder="Masukkan password untuk konfirmasi"
                                   required>
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Diperlukan untuk konfirmasi perubahan</p>
                    </div>
                    
                    {{-- Submit --}}
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.password.edit') }}" class="btn-outline">
                            Kembali
                        </a>
                        <button type="submit" class="btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Pertanyaan Keamanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        {{-- Sidebar Info --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Apa itu Pertanyaan Keamanan?
                </h3>
                <p class="text-sm text-gray-600">
                    Pertanyaan keamanan adalah fitur yang membantu Anda memulihkan akses ke akun jika lupa password. 
                    Dengan menjawab pertanyaan yang sudah Anda atur sebelumnya, Anda dapat mereset password tanpa perlu email.
                </p>
            </div>
            
            {{-- Tips --}}
            <div class="bg-amber-50 rounded-xl p-6">
                <h3 class="font-semibold text-amber-800 mb-3 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Tips Penting
                </h3>
                <ul class="text-sm text-amber-700 space-y-2">
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
                        </svg>
                        Pilih pertanyaan yang jawabannya hanya Anda yang tahu
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
                        </svg>
                        Ingat jawaban Anda dengan baik
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
                        </svg>
                        Jangan bagikan jawaban kepada orang lain
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
