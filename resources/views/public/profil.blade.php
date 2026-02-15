@extends('layouts.public')

@section('title', 'Profil BUMNag')

@section('meta_description', 'Profil lengkap BUMNag Madani Lubuk Malako - Sejarah, Visi Misi, dan Struktur Organisasi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 pattern-topo">
    
    {{-- Header --}}
    <div class="text-center mb-12">
        <div class="flex justify-center mb-6">
            <img src="{{ $logoUrl }}" alt="Logo BUMNag Madani" class="h-24 md:h-32 w-auto">
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $profil->nama_bumnag ?? 'BUMNag Madani' }}</h1>
        <p class="text-xl text-primary font-medium">Nagari {{ $profil->nama_nagari ?? 'Lubuk Malako' }}</p>
    </div>
    
    {{-- Bento Grid Layout --}}
    <div class="grid lg:grid-cols-3 gap-6">
        
        {{-- Sejarah (Larger Card) --}}
        <div class="lg:col-span-2 bento-card">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Sejarah</h2>
            </div>
            <div class="prose prose-gray max-w-none">
                {!! nl2br(e($profil->sejarah ?? 'Sejarah BUMNag Madani belum tersedia.')) !!}
            </div>
        </div>
        
        {{-- Kontak Info --}}
        <div class="bento-card">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Kontak</h2>
            </div>
            
            <div class="space-y-4">
                @if($profil->alamat)
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-gray-600 text-sm">{{ $profil->alamat }}</span>
                    </div>
                @endif
                
                @if($profil->telepon)
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-gray-600">{{ $profil->telepon }}</span>
                    </div>
                @endif
                
                @if($profil->email)
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:{{ $profil->email }}" class="text-primary hover:underline">{{ $profil->email }}</a>
                    </div>
                @endif
                
                @if($profil->website)
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                        <a href="{{ $profil->website }}" target="_blank" class="text-primary hover:underline">{{ $profil->website }}</a>
                    </div>
                @endif
            </div>
        </div>
        
        {{-- Visi --}}
        <div class="bento-card bg-primary text-white">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold">Visi</h2>
            </div>
            <p class="text-white/90 leading-relaxed">{{ $profil->visi ?? 'Visi BUMNag Madani belum tersedia.' }}</p>
        </div>
        
        {{-- Misi --}}
        <div class="lg:col-span-2 bento-card">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-secondary/10 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Misi</h2>
            </div>
            
            @php
                $misiArray = $profil->getMisiArray();
            @endphp
            
            @if(count($misiArray) > 0)
                <ol class="space-y-3">
                    @foreach($misiArray as $index => $misi)
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-7 h-7 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm font-semibold">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-gray-600 pt-0.5">{{ $misi }}</span>
                        </li>
                    @endforeach
                </ol>
            @else
                <p class="text-gray-600">Misi BUMNag Madani belum tersedia.</p>
            @endif
        </div>
    </div>
    
    {{-- Struktur Organisasi - Neat Tree Style --}}
    <div class="mt-16 overflow-x-auto pb-12">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Struktur Badan Usaha Milik Nagari (BUMNag) Madani Lubuk Malako</h2>
            <p class="text-gray-600">Pengurus BUMNag Madani Periode Aktif</p>
        </div>
        
        @php
            $strukturOrganisasi = $profil->getStrukturOrganisasiFormatted();
            
            // Group by category
            $pimpinanNagari = collect($strukturOrganisasi)->filter(fn($a) => in_array($a['jabatan'], ['Bamus', 'Penasehat', 'Ketua KAN']));
            $pengawas = collect($strukturOrganisasi)->filter(fn($a) => $a['jabatan'] === 'Pengawas');
            $direktur = collect($strukturOrganisasi)->filter(fn($a) => $a['jabatan'] === 'Direktur')->first();
            $sekretaris = collect($strukturOrganisasi)->filter(fn($a) => $a['jabatan'] === 'Sekretaris')->first();
            $bendahara = collect($strukturOrganisasi)->filter(fn($a) => $a['jabatan'] === 'Bendahara')->first();
            $kepalaUnit = collect($strukturOrganisasi)->filter(fn($a) => str_starts_with($a['jabatan'], 'Kepala Unit'));
            $operasional = collect($strukturOrganisasi)->filter(fn($a) => in_array($a['jabatan'], ['Mandor Panen', 'Mandor Rawat', 'Staf']));
        @endphp

        <div class="tf-tree tf-custom">
            <ul>
                <li>
                    <div class="tf-nc-group">
                        <span class="tf-nc-label">Pimpinan Nagari</span>
                        <div class="flex gap-4 justify-center">
                            @foreach($pimpinanNagari as $anggota)
                                <div class="org-node org-node-top">
                                    <div class="org-avatar">
                                        @if(!empty($anggota['foto']))
                                            <img src="{{ asset('uploads/struktur/' . $anggota['foto']) }}" alt="{{ $anggota['nama'] }}">
                                        @else
                                            <div class="org-avatar-placeholder">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="org-content">
                                        <div class="org-name">{{ $anggota['nama'] }}</div>
                                        <div class="org-role">{{ $anggota['jabatan'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <ul>
                        <li>
                            <div class="tf-nc-group">
                                <span class="tf-nc-label">Pengawas</span>
                                <div class="flex gap-4 justify-center flex-wrap">
                                    @foreach($pengawas as $anggota)
                                        <div class="org-node org-node-sub" style="min-width: 140px;">
                                            <div class="org-avatar sm">
                                                @if(!empty($anggota['foto']))
                                                    <img src="{{ asset('uploads/struktur/' . $anggota['foto']) }}" alt="{{ $anggota['nama'] }}">
                                                @else
                                                    <div class="org-avatar-placeholder">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="org-content">
                                                <div class="org-name text-sm">{{ $anggota['nama'] }}</div>
                                                <div class="org-role text-xs text-secondary font-semibold">Pengawas</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <ul>
                                @if($direktur)
                                <li>
                                    <div class="org-node org-node-director">
                                        <div class="org-avatar large">
                                            @if(!empty($direktur['foto']))
                                                <img src="{{ asset('uploads/struktur/' . $direktur['foto']) }}" alt="{{ $direktur['nama'] }}">
                                            @else
                                                <div class="org-avatar-placeholder bg-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="org-content">
                                            <div class="org-name text-lg">{{ $direktur['nama'] }}</div>
                                            <div class="org-role text-primary font-bold">Direktur</div>
                                        </div>
                                    </div>

                                    <ul>
                                        @if($sekretaris || $bendahara)
                                        <li>
                                            <div class="tf-nc-wrapper">
                                                <div class="flex gap-8 justify-center">
                                                    @if($sekretaris)
                                                    <div class="org-node">
                                                        <div class="org-avatar">
                                                            @if(!empty($sekretaris['foto']))
                                                                <img src="{{ asset('uploads/struktur/' . $sekretaris['foto']) }}" alt="{{ $sekretaris['nama'] }}">
                                                            @else
                                                                <div class="org-avatar-placeholder">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="org-content">
                                                            <div class="org-name">{{ $sekretaris['nama'] }}</div>
                                                            <div class="org-role">Sekretaris</div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    
                                                    @if($bendahara)
                                                    <div class="org-node">
                                                        <div class="org-avatar">
                                                            @if(!empty($bendahara['foto']))
                                                                <img src="{{ asset('uploads/struktur/' . $bendahara['foto']) }}" alt="{{ $bendahara['nama'] }}">
                                                            @else
                                                                <div class="org-avatar-placeholder">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="org-content">
                                                            <div class="org-name">{{ $bendahara['nama'] }}</div>
                                                            <div class="org-role">Bendahara</div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <ul>
                                                @if(count($kepalaUnit) > 0)
                                                <li>
                                                    <div class="flex gap-4 justify-center">
                                                        @foreach($kepalaUnit as $anggota)
                                                            <div class="org-node" style="min-width: 140px;">
                                                                <div class="org-avatar sm">
                                                                    @if(!empty($anggota['foto']))
                                                                        <img src="{{ asset('uploads/struktur/' . $anggota['foto']) }}" alt="{{ $anggota['nama'] }}">
                                                                    @else
                                                                        <div class="org-avatar-placeholder">
                                                                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="org-content">
                                                                    <div class="org-name text-sm">{{ $anggota['nama'] }}</div>
                                                                    <div class="org-role text-xs text-primary">{{ $anggota['jabatan'] }}</div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <ul>
                                                        @if(count($operasional) > 0)
                                                        <li>
                                                            <div class="flex gap-4 justify-center flex-wrap max-w-4xl mx-auto pt-6 border-t border-dashed border-gray-300 mt-6">
                                                                @foreach($operasional as $anggota)
                                                                    <div class="org-node" style="min-width: 160px;">
                                                                        <div class="org-avatar sm">
                                                                             @if(!empty($anggota['foto']))
                                                                                <img src="{{ asset('uploads/struktur/' . $anggota['foto']) }}" alt="{{ $anggota['nama'] }}">
                                                                            @else
                                                                                <div class="org-avatar-placeholder">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="org-content">
                                                                            <div class="org-name text-sm">{{ $anggota['nama'] }}</div>
                                                                            <div class="org-role text-xs text-primary font-semibold">{{ $anggota['jabatan'] }}</div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </li>
                                                @endif
                                            </ul>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <style>
            /* Treefoundry-like simplified CSS */
            .tf-tree { text-align: center; font-size: 0; min-width: 100%; }
            .tf-tree ul { display: inline-flex; padding: 0; margin: 0; list-style: none; position: relative; }
            .tf-tree ul ul { display: flex; margin-top: 1.5rem; } /* Gap vertical */
            .tf-tree li { position: relative; padding: 0 1rem; }
            
            /* The Lines */
            .tf-tree ul ul::before {
                content: ''; position: absolute; top: -1.5rem; left: 50%; width: 0; height: 1.5rem;
                border-left: 2px solid #ccc;
            }
            .tf-tree li::before, .tf-tree li::after {
                content: ''; position: absolute; top: -1.5rem; right: 50%; width: 50%; height: 1.5rem;
                border-top: 2px solid #ccc;
            }
            .tf-tree li::after { right: auto; left: 50%; border-left: 2px solid #ccc; }
            .tf-tree li:only-child::after, .tf-tree li:only-child::before { display: none; }
            .tf-tree li:only-child { padding-top: 0; }
            .tf-tree li:first-child::before, .tf-tree li:last-child::after { border: 0 none; }
            .tf-tree li:last-child::before { border-right: 2px solid #ccc; border-radius: 0 5px 0 0; }
            .tf-tree li:first-child::after { border-radius: 5px 0 0 0; }
            
            /* Node Styling */
            .tf-custom .org-node {
                display: inline-block;
                background: white;
                border: 1px solid #e5e7eb;
                padding: 1rem;
                border-radius: 12px;
                width: 180px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                transition: all 0.2s;
                position: relative;
                z-index: 2;
                font-size: 1rem;
            }
            .tf-custom .org-node:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.05); border-color: #86ae5f; }
            
            .tf-custom .org-node-top { background: linear-gradient(to bottom, #f0fdf4, #fff); border-color: #bbf7d0; }
            .tf-custom .org-node-director { width: 220px; border-top: 3px solid #86ae5f; }
            .tf-custom .org-node-sub { width: auto; min-width: 140px; padding: 0.75rem 1rem; }
            
            /* Avatars */
            .org-avatar { width: 60px; height: 60px; margin: 0 auto 0.75rem; border-radius: 50%; overflow: hidden; border: 2px solid #f3f4f6; }
            .org-avatar.large { width: 80px; height: 80px; border-color: #86ae5f; }
            .org-avatar.sm { width: 48px; height: 48px; margin-bottom: 0.5rem; }
            .org-avatar img { width: 100%; height: 100%; object-fit: cover; }
            .org-avatar-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f9fafb; }
            .org-avatar-placeholder svg { width: 60%; height: 60%; }
            
            /* Typography */
            .org-name { font-weight: 700; color: #111827; line-height: 1.2; margin-bottom: 0.25rem; font-size: 0.95rem; }
            .org-role { font-size: 0.8rem; color: #6b7280; font-weight: 500; text-transform: uppercase; letter-spacing: 0.025em; }
            
            .org-name-sm { font-weight: 600; font-size: 0.875rem; color: #1f2937; }
            .org-role-sm { font-size: 0.7rem; color: #86ae5f; font-weight: 600; text-transform: uppercase; }

            /* Group Labels */
            .tf-nc-group { background: white; border: 1px dashed #d1d5db; padding: 1rem; border-radius: 16px; position: relative; }
            .tf-nc-label { position: absolute; top: -0.75rem; left: 50%; transform: translateX(-50%); background: #f3f4f6; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.7rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid #e5e7eb; }
        </style>
    </div>
</div>
@endsection
