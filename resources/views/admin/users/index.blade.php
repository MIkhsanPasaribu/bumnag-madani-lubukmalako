@extends('layouts.admin')

@section('title', 'Kelola Akun Unit')
@section('page_title', 'Kelola Akun Unit')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Akun Unit & Sub Unit</h1>
            <p class="text-gray-600 mt-1">Kelola akun login untuk unit dan sub unit usaha</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Akun
        </a>
    </div>
@endsection

@section('content')
    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-blue-600">{{ $users->total() }}</p>
                <p class="text-xs text-gray-500">Total Akun</p>
            </div>
        </div>
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5" />
                </svg>
            </div>
            <div>
                @php $totalUnit = \App\Models\User::where('role', 'unit')->count(); @endphp
                <p class="text-2xl font-bold text-green-600">{{ $totalUnit }}</p>
                <p class="text-xs text-gray-500">Akun Unit</p>
            </div>
        </div>
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                @php $totalSubUnit = \App\Models\User::where('role', 'sub_unit')->count(); @endphp
                <p class="text-2xl font-bold text-purple-600">{{ $totalSubUnit }}</p>
                <p class="text-xs text-gray-500">Akun Sub Unit</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bento-card-flat mb-6">
        <form method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..." 
                       class="form-input text-sm rounded-lg border-gray-300 w-48">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Role</label>
                <select name="role" class="form-input text-sm rounded-lg border-gray-300">
                    <option value="">Semua Role</option>
                    <option value="unit" {{ request('role') == 'unit' ? 'selected' : '' }}>Unit</option>
                    <option value="sub_unit" {{ request('role') == 'sub_unit' ? 'selected' : '' }}>Sub Unit</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Unit Usaha</label>
                <select name="unit_id" class="form-input text-sm rounded-lg border-gray-300">
                    <option value="">Semua Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary text-sm">Filter</button>
            @if(request()->hasAny(['search', 'role', 'unit_id']))
                <a href="{{ route('admin.users.index') }}" class="btn-outline text-sm">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bento-card-flat overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left font-medium text-gray-500">No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Nama</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Email</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Role</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Unit / Sub Unit</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $i => $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $users->firstItem() + $i }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                @if($user->role === 'unit')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Unit</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Sub Unit</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                @if($user->role === 'unit')
                                    {{ $user->unitUsaha?->nama ?? '-' }}
                                @else
                                    {{ $user->unitUsaha?->nama ?? '-' }} &rarr; {{ $user->subUnitUsaha?->nama ?? '-' }}
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 text-primary hover:bg-primary/10 rounded-lg transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" id="form-reset-pw-{{ $user->id }}">
                                        @csrf
                                        <button type="button" onclick="confirmAction({title:'Reset Password',message:'Reset password akun <strong>{{ addslashes($user->name) }}</strong>?',confirmText:'Ya, Reset',confirmClass:'btn-primary',formId:'form-reset-pw-{{ $user->id }}'})" class="p-1.5 text-yellow-600 hover:bg-yellow-50 rounded-lg transition" title="Reset Password">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" id="form-hapus-user-{{ $user->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmAction({title:'Hapus Akun',message:'Yakin hapus akun <strong>{{ addslashes($user->name) }}</strong>?',confirmText:'Hapus',confirmClass:'bg-red-600 hover:bg-red-700 text-white',formId:'form-hapus-user-{{ $user->id }}'})" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="font-medium">Belum ada akun unit/sub unit</p>
                                <p class="text-sm mt-1">Klik tombol "Tambah Akun" untuk membuat akun baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
