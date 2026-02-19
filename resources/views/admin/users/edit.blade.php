@extends('layouts.admin')

@section('title', 'Edit Akun')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Akun: {{ $user->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $user->getRoleLabel() }} &mdash; {{ $user->email }}</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bento-card">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" x-data="userForm()">
                @csrf @method('PUT')

                <div class="space-y-6">
                    {{-- Nama Akun --}}
                    <div x-data="{ count: {{ mb_strlen(old('name', $user->name ?? '')) }} }">
                        <label for="name" class="form-label">
                            Nama Akun <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                               maxlength="255"
                               x-on:input="count = $el.value.length"
                               class="form-input w-full @error('name') border-red-500 @enderror" required>
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
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                               class="form-input w-full @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="form-label">
                                Password Baru
                            </label>
                            <input type="password" id="password" name="password"
                                   class="form-input w-full @error('password') border-red-500 @enderror"
                                   placeholder="Kosongkan jika tidak diubah">
                            @error('password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-input w-full"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Biarkan kosong jika tidak ingin mengubah password.</p>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="form-label">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role" x-model="role"
                                class="form-input w-full @error('role') border-red-500 @enderror" required>
                            <option value="unit" {{ old('role', $user->role) == 'unit' ? 'selected' : '' }}>Unit Usaha</option>
                            <option value="sub_unit" {{ old('role', $user->role) == 'sub_unit' ? 'selected' : '' }}>Sub Unit Usaha</option>
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
                            <template x-for="unit in availableUnits" :key="unit.id">
                                <option :value="unit.id" x-text="unit.nama"></option>
                            </template>
                        </select>
                        <p class="mt-1 text-xs text-gray-400" x-show="role === 'sub_unit' && availableUnits.length > 0">
                            Hanya unit yang memiliki sub unit yang ditampilkan.
                        </p>
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
                        @error('sub_unit_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="btn-primary px-6 py-2.5 rounded-lg font-medium">
                            Perbarui Akun
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
    const allUnits = @json($units->map(fn ($u) => ['id' => $u->id, 'nama' => $u->nama]));
    const unitsWithSubUnits = @json($unitsWithSubUnits->map(fn ($u) => ['id' => $u->id, 'nama' => $u->nama]));

    return {
        role: '{{ old("role", $user->role) }}',
        unitId: '{{ old("unit_id", $user->unit_id) }}',
        subUnitId: '{{ old("sub_unit_id", $user->sub_unit_id) }}',
        subUnits: [],
        allUnits,
        unitsWithSubUnits,

        get availableUnits() {
            return this.role === 'sub_unit' ? this.unitsWithSubUnits : this.allUnits;
        },

        init() {
            // Saat role berubah, filter unit & reset sub unit jika perlu
            this.$watch('role', (newRole) => {
                if (newRole === 'sub_unit') {
                    // Jika unit yang dipilih tidak punya sub unit, reset
                    const unitValid = this.unitsWithSubUnits.find(u => String(u.id) === String(this.unitId));
                    if (!unitValid) {
                        this.unitId = '';
                        this.subUnits = [];
                        this.subUnitId = '';
                    } else {
                        this.loadSubUnits();
                    }
                } else {
                    // Kembali ke role unit, hapus sub unit
                    this.subUnitId = '';
                    this.subUnits = [];
                }
            });

            if (this.unitId) this.loadSubUnits();
        },

        async loadSubUnits() {
            this.subUnits = [];
            if (!this.unitId) return;
            try {
                const res = await fetch(`/admin/users/sub-units/${this.unitId}`);
                const data = await res.json();
                this.subUnits = data;
                const oldSub = '{{ old("sub_unit_id", $user->sub_unit_id) }}';
                if (oldSub && this.subUnits.find(s => String(s.id) === String(oldSub))) {
                    this.subUnitId = oldSub;
                }
            } catch (e) {
                console.error('Gagal memuat sub unit:', e);
            }
        }
    }
}
</script>
@endpush
