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
    
    {{-- Struktur Organisasi --}}
    <div class="mt-16 pb-20">

        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Struktur Badan Usaha Milik Nagari (BUMNag) Madani Lubuk Malako</h2>
            <p class="text-gray-500">Pengurus BUMNag Madani Periode Aktif</p>
        </div>

        @php
            $strukturOrganisasi = $profil->getStrukturOrganisasiFormatted();
            $pimpinanNagari = collect($strukturOrganisasi)->filter(fn($a) => in_array($a['jabatan'], ['Bamus', 'Penasehat', 'Ketua KAN']))->values();
            $pengawas       = collect($strukturOrganisasi)->filter(fn($a) => $a['jabatan'] === 'Pengawas')->values();
            $direktur       = collect($strukturOrganisasi)->firstWhere('jabatan', 'Direktur');
            $sekretaris     = collect($strukturOrganisasi)->firstWhere('jabatan', 'Sekretaris');
            $bendahara      = collect($strukturOrganisasi)->firstWhere('jabatan', 'Bendahara');
            $kepalaUnit     = collect($strukturOrganisasi)->filter(fn($a) => str_starts_with($a['jabatan'], 'Kepala Unit'))->values();
            $operasional    = collect($strukturOrganisasi)->filter(fn($a) => in_array($a['jabatan'], ['Mandor Panen', 'Mandor Rawat', 'Staf']))->values();
        @endphp

        {{-- ══ ZONA OPERASIONAL: Tiered row layout ══ --}}
        <div class="org-tiers">

            {{-- Tier 1: Direktur --}}
            @if($direktur)
            <div class="org-tier">
                <div class="org-tier-label">Direktur</div>
                <div class="org-tier-cards">
                    <div class="org-card org-card--lg org-card--primary">
                        <div class="org-card-photo">
                            @if(!empty($direktur['foto']))
                                <img src="{{ asset('uploads/struktur/' . $direktur['foto']) }}" alt="{{ $direktur['nama'] }}">
                            @else
                                <div class="org-card-placeholder org-card-placeholder--primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                            @endif
                            <div class="org-card-overlay">
                                <div class="org-card-name">{{ $direktur['nama'] }}</div>
                                <div class="org-card-role org-card-role--primary">Direktur</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Tier connector --}}
            @if($direktur && ($sekretaris || $bendahara))
            <div class="org-tier-connector">
                <div class="org-tier-connector-line"></div>
                <svg class="org-tier-connector-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#86ae5f"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
            </div>
            @endif

            {{-- Tier 2: Sekretaris + Bendahara --}}
            @if($sekretaris || $bendahara)
            <div class="org-tier">
                <div class="org-tier-label">Sekretariat &amp; Keuangan</div>
                <div class="org-tier-cards">
                    @if($sekretaris)
                    <div class="org-card">
                        <div class="org-card-photo">
                            @if(!empty($sekretaris['foto']))
                                <img src="{{ asset('uploads/struktur/' . $sekretaris['foto']) }}" alt="{{ $sekretaris['nama'] }}">
                            @else
                                <div class="org-card-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                            @endif
                            <div class="org-card-overlay">
                                <div class="org-card-name">{{ $sekretaris['nama'] }}</div>
                                <div class="org-card-role">Sekretaris</div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($bendahara)
                    <div class="org-card">
                        <div class="org-card-photo">
                            @if(!empty($bendahara['foto']))
                                <img src="{{ asset('uploads/struktur/' . $bendahara['foto']) }}" alt="{{ $bendahara['nama'] }}">
                            @else
                                <div class="org-card-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                            @endif
                            <div class="org-card-overlay">
                                <div class="org-card-name">{{ $bendahara['nama'] }}</div>
                                <div class="org-card-role">Bendahara</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Tier connector --}}
            @if($kepalaUnit->count() > 0)
            <div class="org-tier-connector">
                <div class="org-tier-connector-line"></div>
                <svg class="org-tier-connector-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#86ae5f"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
            </div>

            {{-- Tier 3: Kepala Unit --}}
            <div class="org-tier">
                <div class="org-tier-label">Kepala Unit</div>
                <div class="org-tier-cards">
                    @foreach($kepalaUnit as $anggota)
                    <div class="org-card org-card--sm">
                        <div class="org-card-photo">
                            @if(!empty($anggota['foto']))
                                <img src="{{ asset('uploads/struktur/' . $anggota['foto']) }}" alt="{{ $anggota['nama'] }}">
                            @else
                                <div class="org-card-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                            @endif
                            <div class="org-card-overlay">
                                <div class="org-card-name">{{ $anggota['nama'] }}</div>
                                <div class="org-card-role">{{ $anggota['jabatan'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Tier connector + Tier 4: Operasional --}}
            @if($operasional->count() > 0)
            <div class="org-tier-connector">
                <div class="org-tier-connector-line org-tier-connector-line--dashed"></div>
                <svg class="org-tier-connector-arrow org-tier-connector-arrow--gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
            </div>
            <div class="org-tier">
                <div class="org-tier-label org-tier-label--gray">Operasional</div>
                <div class="org-tier-cards">
                    @foreach($operasional as $anggota)
                    <div class="org-card org-card--sm org-card--gray">
                        <div class="org-card-photo">
                            @if(!empty($anggota['foto']))
                                <img src="{{ asset('uploads/struktur/' . $anggota['foto']) }}" alt="{{ $anggota['nama'] }}">
                            @else
                                <div class="org-card-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                            @endif
                            <div class="org-card-overlay">
                                <div class="org-card-name">{{ $anggota['nama'] }}</div>
                                <div class="org-card-role">{{ $anggota['jabatan'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>{{-- /.org-tiers --}}

        {{-- ══ ZONA PENGAWASAN — di bawah, terpisah, tidak terhubung ══ --}}
        @if($pimpinanNagari->count() > 0 || $pengawas->count() > 0)
        <div class="mt-16">
            <div class="flex items-center gap-3 mb-3 px-4 max-w-3xl mx-auto">
                <div class="flex-1 border-t-2 border-dashed border-gray-300"></div>
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest text-gray-500 bg-white border border-gray-300 whitespace-nowrap shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Pimpinan Nagari &amp; Badan Pengawas
                </span>
                <div class="flex-1 border-t-2 border-dashed border-gray-300"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto px-4">

                @if($pimpinanNagari->count() > 0)
                <div class="org-supervisory-panel">
                    <div class="org-supervisory-title org-supervisory-title--green">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Pimpinan Nagari
                    </div>
                    <div class="flex flex-wrap gap-3 justify-center">
                        @foreach($pimpinanNagari as $anggota)
                        <div class="org-card org-card--sm">
                            <div class="org-card-photo">
                                @if(!empty($anggota['foto']))
                                    <img src="{{ asset('uploads/struktur/' . $anggota['foto']) }}" alt="{{ $anggota['nama'] }}">
                                @else
                                    <div class="org-card-placeholder org-card-placeholder--green">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                @endif
                                <div class="org-card-overlay">
                                    <div class="org-card-name">{{ $anggota['nama'] }}</div>
                                    <div class="org-card-role">{{ $anggota['jabatan'] }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($pengawas->count() > 0)
                <div class="org-supervisory-panel org-supervisory-panel--red">
                    <div class="org-supervisory-title org-supervisory-title--red">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Pengawas
                    </div>
                    <div class="flex flex-wrap gap-3 justify-center">
                        @foreach($pengawas as $anggota)
                        <div class="org-card org-card--sm">
                            <div class="org-card-photo">
                                @if(!empty($anggota['foto']))
                                    <img src="{{ asset('uploads/struktur/' . $anggota['foto']) }}" alt="{{ $anggota['nama'] }}">
                                @else
                                    <div class="org-card-placeholder org-card-placeholder--red">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                @endif
                                <div class="org-card-overlay">
                                    <div class="org-card-name">{{ $anggota['nama'] }}</div>
                                    <div class="org-card-role">Pengawas</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
        @endif

    </div>

    <style>
        /* ── Tiered layout wrapper ─────────────────────────────── */
        .org-tiers {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
        }

        /* Each "row" tier */
        .org-tier {
            width: 100%;
            max-width: 900px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .org-tier-label {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            border-radius: 999px;
            padding: 0.18rem 0.9rem;
            margin-bottom: 0.85rem;
        }
        .org-tier-label--gray { color: #374151; background: #f3f4f6; border-color: #e5e7eb; }

        /* Cards row inside a tier */
        .org-tier-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        /* Connector between tiers */
        .org-tier-connector {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.25rem 0;
        }
        .org-tier-connector-line {
            width: 2px;
            height: 1.75rem;
            background: #86ae5f;
        }
        .org-tier-connector-line--dashed {
            background: none;
            border-left: 2px dashed #d1d5db;
        }
        .org-tier-connector-arrow {
            width: 1.25rem;
            height: 1.25rem;
            margin-top: -0.2rem;
        }

        /* ── Portrait Card ────────────────────────────────────── */
        .org-card {
            width: 140px;
            flex-shrink: 0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0,0,0,0.10);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .org-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 28px rgba(0,0,0,0.14);
        }
        .org-card--lg  { width: 170px; }
        .org-card--sm  { width: 115px; }
        .org-card--primary { box-shadow: 0 8px 24px rgba(134,174,95,0.30); }
        .org-card--primary:hover { box-shadow: 0 16px 36px rgba(134,174,95,0.40); }
        .org-card--gray { opacity: 0.92; }

        /* Photo 3:4 ratio */
        .org-card-photo {
            position: relative;
            width: 100%;
            padding-bottom: 130%;
            background: #f3f4f6;
            overflow: hidden;
        }
        .org-card-photo img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
        }

        /* Placeholder */
        .org-card-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
        }
        .org-card-placeholder--primary { background: linear-gradient(135deg, #86ae5f 0%, #6b9a45 100%); }
        .org-card-placeholder--green   { background: linear-gradient(135deg, #86ae5f 0%, #6b9a45 100%); }
        .org-card-placeholder--red     { background: linear-gradient(135deg, #b71e42 0%, #8f1734 100%); }
        .org-card-placeholder svg { width: 38%; height: 38%; opacity: 0.55; }
        .org-card-placeholder--primary svg,
        .org-card-placeholder--green svg,
        .org-card-placeholder--red svg { opacity: 0.9; }

        /* Overlay */
        .org-card-overlay {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 1.5rem 0.55rem 0.6rem;
            background: linear-gradient(to top, rgba(0,0,0,0.82) 0%, rgba(0,0,0,0.42) 55%, transparent 100%);
        }
        .org-card-name {
            font-weight: 700;
            font-size: 0.76rem;
            color: #fff;
            line-height: 1.25;
            margin-bottom: 0.18rem;
        }
        .org-card-role {
            font-size: 0.6rem;
            color: rgba(255,255,255,0.80);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .org-card-role--primary { color: #c5dfa6; }

        /* ── Supervisory panels ──────────────────────────────── */
        .org-supervisory-panel {
            background: white;
            border: 2px dashed #bbf7d0;
            border-radius: 18px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .org-supervisory-panel--red { border-color: #fecaca; }

        .org-supervisory-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 1.25rem;
        }
        .org-supervisory-title--green { color: #166534; }
        .org-supervisory-title--red   { color: #991b1b; }
    </style>

</div>
@endsection
