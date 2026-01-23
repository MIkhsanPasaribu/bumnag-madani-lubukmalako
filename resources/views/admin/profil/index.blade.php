@extends('layouts.admin')

@section('title', 'Profil BUMNag')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span class="current">Profil BUMNag</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-bumnag-gray">Profil BUMNag</h1>
            <p class="text-gray-500">Kelola informasi profil organisasi</p>
        </div>
        <a href="{{ route('admin.profil.edit') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Profil
        </a>
    </div>
    
    @if($profil)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card-admin">
            <h3 class="font-semibold text-lg text-bumnag-gray mb-4">Informasi Umum</h3>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm text-gray-500">Nama Organisasi</dt>
                    <dd class="font-medium text-bumnag-gray">{{ $profil->nama }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Tahun Berdiri</dt>
                    <dd class="font-medium text-bumnag-gray">{{ $profil->tahun_berdiri ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Deskripsi</dt>
                    <dd class="text-gray-600 text-sm">{{ $profil->deskripsi ?? '-' }}</dd>
                </div>
            </dl>
        </div>
        
        <div class="card-admin">
            <h3 class="font-semibold text-lg text-bumnag-gray mb-4">Kontak</h3>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm text-gray-500">Alamat</dt>
                    <dd class="text-gray-600 text-sm">{{ $profil->alamat ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Telepon</dt>
                    <dd class="font-medium text-bumnag-gray">{{ $profil->telepon ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Email</dt>
                    <dd class="font-medium text-bumnag-gray">{{ $profil->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Website</dt>
                    <dd class="font-medium text-bumnag-olive">{{ $profil->website ?? '-' }}</dd>
                </div>
            </dl>
        </div>
        
        <div class="card-admin">
            <h3 class="font-semibold text-lg text-bumnag-gray mb-4">Visi</h3>
            <p class="text-gray-600 text-sm">{{ $profil->visi ?? '-' }}</p>
        </div>
        
        <div class="card-admin">
            <h3 class="font-semibold text-lg text-bumnag-gray mb-4">Misi</h3>
            <div class="text-gray-600 text-sm whitespace-pre-line">{{ $profil->misi ?? '-' }}</div>
        </div>
        
        <div class="card-admin lg:col-span-2">
            <h3 class="font-semibold text-lg text-bumnag-gray mb-4">Sejarah</h3>
            <div class="text-gray-600 text-sm whitespace-pre-line">{{ $profil->sejarah ?? '-' }}</div>
        </div>
    </div>
    @else
    <div class="card-admin text-center py-12">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Profil Belum Diatur</h3>
        <p class="text-gray-500 mb-4">Silakan lengkapi informasi profil organisasi.</p>
        <a href="{{ route('admin.profil.edit') }}" class="btn-primary">Lengkapi Profil</a>
    </div>
    @endif
</div>
@endsection
