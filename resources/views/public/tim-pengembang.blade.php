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
    <br>
    <br>

    {{-- Tech Stack Section --}}
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Teknologi yang Digunakan</h2>
            <p class="text-gray-600">Tech stack yang membangun website ini</p>
        </div>
        
        <div class="flex flex-wrap justify-center items-center gap-4 sm:gap-6">
            {{-- Laravel --}}
            <div class="group flex items-center gap-3 px-5 py-3 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <svg class="w-8 h-8 text-[#FF2D20]" viewBox="0 0 50 52" fill="currentColor">
                    <path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.646 2.675v9.124l8.01-4.611zm-9.61 16.505v-9.13l-4.57 2.61-13.05 7.448v9.216l17.62-10.144zM1.602 7.719v31.068L19.22 48.93v-9.214l-9.204-5.209-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.012-.078-.016-.117-.004-.03-.012-.06-.012-.09v-.002-21.481L4.965 9.654 1.602 7.72zm8.81-5.994L2.405 6.334l8.005 4.609 8.006-4.61-8.006-4.608zm4.164 28.764l4.645-2.674V7.719l-3.363 1.936-4.646 2.675v20.096l3.364-1.937zM39.243 7.164l-8.006 4.609 8.006 4.609 8.005-4.61-8.005-4.608zm-.801 10.605l-4.646-2.675-3.363-1.936v9.124l4.645 2.674 3.364 1.937v-9.124zM20.02 38.33l11.743-6.704 5.87-3.35-8-4.606-9.211 5.303-8.395 4.833 7.993 4.524z"/>
                </svg>
                <span class="font-semibold text-gray-700 group-hover:text-[#FF2D20] transition-colors">Laravel 11</span>
            </div>

            {{-- PHP --}}
            <div class="group flex items-center gap-3 px-5 py-3 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <svg class="w-8 h-8 text-[#777BB4]" viewBox="0 0 256 134" fill="currentColor">
                    <ellipse cx="128" cy="66.63" rx="128" ry="66.63" fill="#777BB4"/>
                    <path d="M35.945 106.082l14.028-71.014h29.893c12.693 0 21.551 2.432 26.573 7.296 5.022 4.865 6.588 11.983 4.698 21.354-1.233 6.116-3.542 11.549-6.926 16.298-3.385 4.75-7.658 8.619-12.821 11.607-3.943 2.323-8.383 3.977-13.319 4.962-4.935.984-10.72 1.477-17.352 1.477H49.434l-4.318 21.854H35.945v-.434l-.001.6zm21.643-32.21h8.546c7.256 0 13.014-.868 17.274-2.605 4.26-1.737 7.341-5.023 9.243-9.858.887-2.257 1.331-4.399 1.331-6.423 0-3.396-1.063-5.926-3.188-7.591-2.126-1.664-5.577-2.497-10.356-2.497h-15.71l-7.14 28.974z" fill="#FFF"/>
                    <path d="M119.993 106.082l14.028-71.014h29.893c12.693 0 21.551 2.432 26.574 7.296 5.022 4.865 6.588 11.983 4.697 21.354-1.233 6.116-3.542 11.549-6.926 16.298-3.385 4.75-7.658 8.619-12.821 11.607-3.944 2.323-8.383 3.977-13.319 4.962-4.935.984-10.72 1.477-17.352 1.477h-11.285l-4.318 21.854h-9.171v-.434l.001.6h-.001zm21.643-32.21h8.546c7.256 0 13.014-.868 17.274-2.605 4.26-1.737 7.341-5.023 9.243-9.858.887-2.257 1.331-4.399 1.331-6.423 0-3.396-1.063-5.926-3.188-7.591-2.126-1.664-5.577-2.497-10.356-2.497h-15.71l-7.14 28.974z" fill="#FFF"/>
                </svg>
                <span class="font-semibold text-gray-700 group-hover:text-[#777BB4] transition-colors">PHP 8.4</span>
            </div>

            {{-- Tailwind CSS --}}
            <div class="group flex items-center gap-3 px-5 py-3 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <svg class="w-8 h-8 text-[#06B6D4]" viewBox="0 0 54 33" fill="currentColor">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M27 0c-7.2 0-11.7 3.6-13.5 10.8 2.7-3.6 5.85-4.95 9.45-4.05 2.054.514 3.522 2.004 5.147 3.653C30.744 13.09 33.808 16.2 40.5 16.2c7.2 0 11.7-3.6 13.5-10.8-2.7 3.6-5.85 4.95-9.45 4.05-2.054-.514-3.522-2.004-5.147-3.653C36.756 3.11 33.692 0 27 0zM13.5 16.2C6.3 16.2 1.8 19.8 0 27c2.7-3.6 5.85-4.95 9.45-4.05 2.054.514 3.522 2.004 5.147 3.653C17.244 29.29 20.308 32.4 27 32.4c7.2 0 11.7-3.6 13.5-10.8-2.7 3.6-5.85 4.95-9.45 4.05-2.054-.514-3.522-2.004-5.147-3.653C23.256 19.31 20.192 16.2 13.5 16.2z"/>
                </svg>
                <span class="font-semibold text-gray-700 group-hover:text-[#06B6D4] transition-colors">Tailwind CSS</span>
            </div>

            {{-- MySQL --}}
            <div class="group flex items-center gap-3 px-5 py-3 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <svg class="w-8 h-8 text-[#4479A1]" viewBox="0 0 128 128" fill="currentColor">
                    <path d="M116.948 97.807c-6.863-.187-12.104.452-16.585 2.341-1.273.537-3.305.552-3.513 2.147.7.733.807 1.829 1.365 2.731 1.07 1.73 2.876 4.052 4.488 5.268 1.762 1.33 3.577 2.751 5.465 3.902 3.358 2.047 7.107 3.217 10.34 5.268 1.906 1.21 3.799 2.733 5.658 4.097.92.675 1.537 1.724 2.732 2.147v-.194c-.628-.8-.79-1.898-1.366-2.733l-2.537-2.537c-2.48-3.292-5.629-6.184-8.976-8.585-2.669-1.916-8.642-4.504-9.755-7.609l-.195-.195c1.892-.214 4.107-.898 5.854-1.367 2.934-.786 5.556-.583 8.585-1.365l4.097-1.171v-.78c-1.531-1.571-2.623-3.651-4.292-5.073-4.37-3.72-9.138-7.437-14.048-10.537-2.724-1.718-6.089-2.835-8.976-4.292-.971-.491-2.677-.746-3.318-1.562-1.517-1.932-2.342-4.382-3.511-6.633-2.449-4.717-4.854-9.868-7.024-14.831-1.48-3.384-2.447-6.72-4.293-9.756-8.86-14.567-18.396-23.358-33.169-32-3.144-1.838-6.929-2.563-10.929-3.513-2.145-.129-4.292-.26-6.438-.391-1.311-.546-2.673-2.149-3.902-2.927C17.811 4.565 5.257-2.17 1.633 6.682c-2.289 5.581 3.421 11.025 5.462 13.854 1.434 1.982 3.269 4.207 4.293 6.438.674 1.467.79 2.938 1.367 4.489 1.417 3.822 2.652 7.98 4.487 11.511.927 1.788 1.949 3.67 3.122 5.268.718.981 1.951 1.413 2.145 2.927-1.204 1.686-1.273 4.304-1.95 6.44-3.05 9.615-1.899 21.567 2.537 28.683 1.36 2.186 4.567 6.871 8.975 5.073 3.856-1.57 2.995-6.438 4.098-10.732.249-.973.096-1.689.585-2.341v.195l3.513 7.024c2.6 4.187 7.212 8.562 11.122 11.514 2.027 1.531 3.623 4.177 6.244 5.073v-.196h-.195c-.508-.791-1.303-1.119-1.951-1.755-1.527-1.497-3.225-3.358-4.487-5.073-3.556-4.827-6.698-10.11-9.561-15.609-1.368-2.627-2.557-5.523-3.709-8.196-.444-1.03-.438-2.589-1.364-3.122-1.263 1.958-3.122 3.542-4.098 5.854-1.561 3.696-1.762 8.204-2.341 12.878-.342.122-.19.038-.391.194-2.718-.655-3.672-3.452-4.683-5.853-2.554-6.07-3.029-15.842-.781-22.829.582-1.809 3.21-7.501 2.146-9.172-.508-1.666-2.184-2.63-3.121-3.903-1.161-1.574-2.319-3.646-3.124-5.464-2.09-4.731-3.066-10.044-5.267-14.828-1.053-2.287-2.832-4.602-4.293-6.634-1.617-2.253-3.429-3.912-4.683-6.635-.446-.968-1.051-2.518-.391-3.513.21-.671.507-.951 1.171-1.17 1.132-.873 4.284.29 5.462.779 3.129 1.3 5.741 2.538 8.392 4.294 1.271.844 2.559 2.475 4.097 2.927h1.756c2.747.631 5.824.195 8.391.975 4.536 1.378 8.601 3.523 12.292 5.854 11.246 7.102 20.442 17.21 26.732 29.269 1.012 1.942 1.45 3.794 2.341 5.854 1.798 4.153 4.063 8.426 5.852 12.488 1.786 4.052 3.526 8.141 6.05 11.513 1.327 1.772 6.451 2.723 8.781 3.708 1.632.689 4.307 1.409 5.854 2.34 2.953 1.782 5.815 3.903 8.586 5.855 1.383.975 5.64 3.116 5.852 4.879zM29.729 23.466c-1.431-.027-2.443.156-3.513.389v.195h.195c.683 1.402 1.888 2.306 2.731 3.513.65 1.367 1.301 2.732 1.952 4.097l.194-.193c1.209-.853 1.762-2.214 1.755-4.294-.484-.509-.555-1.147-.975-1.755-.473-.69-1.39-1.073-1.95-1.755l-.389-.197z"/>
                </svg>
                <span class="font-semibold text-gray-700 group-hover:text-[#4479A1] transition-colors">MySQL</span>
            </div>

            {{-- Alpine.js --}}
            <div class="group flex items-center gap-3 px-5 py-3 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <svg class="w-8 h-8 text-[#8BC0D0]" viewBox="0 0 256 170" fill="currentColor">
                    <path d="M128 0L0 128h64l64-64 64 64h64L128 0z"/>
                    <path d="M64 170L0 106v64l64 42 64-42v-64L64 170z" fill-opacity=".5"/>
                    <path d="M192 170l-64-64v64l64 42 64-42v-64l-64 64z" fill-opacity=".5"/>
                </svg>
                <span class="font-semibold text-gray-700 group-hover:text-[#8BC0D0] transition-colors">Alpine.js</span>
            </div>
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
