@extends('layouts.public')

@section('title', 'Tim Pengembang')

@section('meta_description', 'Tim pengembang website BUMNag Madani Lubuk Malako - Mahasiswa Pendidikan Teknik Informatika Universitas Negeri Padang')

@push('styles')
<style>
    :root {
        --bumnag-primary: #86ae5f;
        --bumnag-primary-dark: #6b9a45;
        --bumnag-secondary: #b71e42;
        --bumnag-cream: #fffaed;
    }
    
    .developer-card {
        position: relative;
        width: 300px;
        flex: 0 0 auto;
        height: 420px;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
    }

    @media (max-width: 640px) {
        .developer-card {
            width: 100%;
            max-width: 320px;
            height: 400px;
        }
    }
    
    .developer-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: var(--bumnag-primary);
    }
    
    .card-image-wrapper {
        height: 100%;
        width: 100%;
        position: relative;
    }
    
    .card-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top;
        transition: transform 0.5s ease;
    }
    
    .developer-card:hover .card-image-wrapper img {
        transform: scale(1.05);
    }
    
    .card-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(107, 154, 69, 0.95) 0%, rgba(107, 154, 69, 0.8) 60%, transparent 100%);
        padding: 24px;
        color: white;
        transform: translateY(20px);
        transition: transform 0.4s ease;
    }
    
    .developer-card:hover .card-content {
        transform: translateY(0);
    }
    
    .role-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 20;
        display: inline-block;
        padding: 6px 14px;
        background: var(--bumnag-secondary);
        color: white;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        max-width: calc(100% - 40px);
        white-space: normal;
        line-height: 1.3;
        text-align: left;
    }

    @media (max-width: 640px) {
        .role-badge {
            font-size: 10px;
            padding: 5px 12px;
            top: 15px;
            left: 15px;
            border-radius: 8px;
        }
    }
    
    .social-links {
        display: flex;
        gap: 12px;
        margin-top: 16px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease 0.1s;
    }
    
    .developer-card:hover .social-links {
        opacity: 1;
        transform: translateY(0);
    }
    
    .social-link {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.2s ease;
    }
    
    .social-link:hover {
        background: white;
        color: var(--bumnag-primary-dark);
        transform: scale(1.1);
    }
    
    .social-link.instagram:hover {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        color: white;
    }
    
    .social-link.linkedin:hover {
        background: #0077B5;
        color: white;
    }
    
    .social-link.github:hover {
        background: #333;
        color: white;
    }
    
    .social-link.portfolio:hover {
        background: var(--bumnag-primary);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-cream via-white to-cream py-12 px-4 sm:px-6 lg:px-8">
    
    {{-- Header Section --}}
    <div class="max-w-5xl mx-auto text-center mb-16">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
            Developer Team
        </span>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 tracking-tight">
            Tim <span class="text-primary">Pengembang</span>
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Mahasiswa Pendidikan Teknik Informatika Universitas Negeri Padang yang membangun website BUMNag Madani Lubuk Malako
        </p>
    </div>
    <br>

    {{-- Developer Cards --}}
    <div class="max-w-5xl mx-auto mb-16">
        <div class="flex flex-wrap justify-center gap-8">
            
            @foreach($developers as $developer)
            <div class="developer-card">
                <div class="role-badge">{{ $developer['title'] }}</div>
                <div class="card-image-wrapper">
                    <img src="{{ asset('images/' . $developer['foto']) }}" alt="{{ $developer['nama'] }}" loading="lazy">
                </div>
                <div class="card-content">
                    <h3 class="inline-block text-xl font-bold leading-tight px-3 py-1.5 rounded-lg" style="background-color: #b71e42; color: white;">{{ $developer['nama'] }}</h3>
                    <p class="text-green-100 text-sm mt-2 font-medium">NIM: {{ $developer['nim'] }}</p>
                    <p class="text-green-200 text-xs mt-0.5">{{ $developer['prodi'] }}</p>
                    
                    <div class="social-links">
                        <a href="{{ $developer['sosmed']['github'] }}" target="_blank" rel="noopener noreferrer" class="social-link github" title="GitHub">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                        <a href="{{ $developer['sosmed']['instagram'] }}" target="_blank" rel="noopener noreferrer" class="social-link instagram" title="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="{{ $developer['sosmed']['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="social-link linkedin" title="LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <a href="{{ $developer['sosmed']['portfolio'] }}" target="_blank" rel="noopener noreferrer" class="social-link portfolio" title="Portfolio">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

    {{-- Back to Home --}}
    <br>
    <br>
    <div class="text-center mt-12">
        <a 
            href="{{ route('beranda') }}" 
            class="inline-flex items-center gap-2 px-6 py-3 bg-primary text -white rounded-xl font-semibold hover:bg-primary-dark transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
