@extends('layouts.admin')

@section('title', 'Tambah Akun')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Akun Unit / Sub Unit</h1>
            <p class="text-gray-600 mt-1">Buat akun baru untuk unit atau sub unit usaha</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bento-card">
            <form action="{{ route('admin.users.store') }}" method="POST" x-data="userForm()">
                @csrf

                <div class="space-y-6">
                    {{-- Nama Akun --}}
                    <div x-data="{ count: {{ mb_strlen(old('name', '')) }} }">
                        <label for="name" class="form-label">
                            Nama Akun <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               maxlength="255"
                               x-on:input="count = $el.value.length"
                               class="form-input w-full @error('name') border-red-500 @enderror"
                               placeholder="Contoh: Unit Jasa" required>
                        <div class="flex justify-between items-center mt-1">
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="text-xs ml-auto flex-shrink-0 transition-colors"
                               :class="count >= 230 ? 'text-amber-500 font-medium' : 'text-gray-400'"
                               x-text="count + '/255'">0/255</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="form-label">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-input w-full @error('email') border-red-500 @enderror"
                               placeholder="contoh@bumnagmadani.id" required>
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="form-label">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password" name="password"
                                   class="form-input w-full @error('password') border-red-500 @enderror"
                                   placeholder="Minimal 6 karakter" required>
                            @error('password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-input w-full"
                                   placeholder="Ulangi password" required>
                        </div>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="form-label">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role" x-model="role"
                                class="form-input w-full @error('role') border-red-500 @enderror" required>
                            <option value="">Pilih Role</option>
                            <option value="unit" {{ old('role') == 'unit' ? 'selected' : '' }}>Unit Usaha</option>
                            <option value="sub_unit" {{ old('role') == 'sub_unit' ? 'selected' : '' }}>Sub Unit Usaha</option>
                        </select>
                        @error('role')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Unit Usaha --}}
                    <div>
                        <label for="unit_id" class="form-label">
                            Unit Usaha <span class="text-red-500">*</span>
                        </label>
                        <select id="unit_id" name="unit_id" x-model="unitId" @change="loadSubUnits()"
                                class="form-input w-full @error('unit_id') border-red-500 @enderror" required>
                            <option value="">Pilih Unit Usaha</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->nama }}</option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sub Unit (dynamic) --}}
                    <div x-show="role === 'sub_unit'" x-transition>
                        <label for="sub_unit_id" class="form-label">
                            Sub Unit <span class="text-red-500">*</span>
                        </label>
                        <select id="sub_unit_id" name="sub_unit_id" x-model="subUnitId"
                                class="form-input w-full @error('sub_unit_id') border-red-500 @enderror">
                            <option value="">Pilih Sub Unit</option>
                            <template x-for="sub in subUnits" :key="sub.id">
                                <option :value="sub.id" x-text="sub.nama"></option>
                            </template>
                        </select>
                        <p class="mt-1 text-xs text-gray-400" x-show="!unitId">Pilih unit terlebih dahulu</p>
                        @error('sub_unit_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="btn-primary px-6 py-2.5 rounded-lg font-medium">
                            Simpan Akun
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                           class="px-6 py-2.5 text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg font-medium transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function userForm() {
    return {
        role: '{{ old("role", "") }}',
        unitId: '{{ old("unit_id", "") }}',
        subUnitId: '{{ old("sub_unit_id", "") }}',
        subUnits: [],

        init() {
            if (this.unitId) this.loadSubUnits();
        },

        async loadSubUnits() {
            this.subUnits = [];
            this.subUnitId = '';
            if (!this.unitId) return;
            try {
                const res = await fetch(`/admin/users/sub-units/${this.unitId}`);
                this.subUnits = await res.json();
                const oldSub = '{{ old("sub_unit_id", "") }}';
                if (oldSub) this.subUnitId = oldSub;
            } catch (e) {
                console.error('Gagal memuat sub unit:', e);
            }
        }
    }
}
</script>
@endpush
