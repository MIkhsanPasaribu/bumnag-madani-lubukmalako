<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UnitUsaha;
use App\Models\SubUnitUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Controller untuk mengelola akun Unit & Sub Unit oleh Admin
 */
class UserController extends Controller
{
    /**
     * Daftar semua akun unit & sub unit
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['unit', 'sub_unit'])
            ->with(['unitUsaha', 'subUnitUsaha']);

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter unit
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('role')->orderBy('name')->paginate(15)->withQueryString();
        $units = UnitUsaha::orderBy('nama')->get();

        return view('admin.users.index', compact('users', 'units'));
    }

    /**
     * Form tambah akun baru
     */
    public function create()
    {
        $units = UnitUsaha::where('is_active', true)->orderBy('nama')->get();
        $subUnits = SubUnitUsaha::where('is_active', true)->with('unit')->orderBy('nama')->get();

        return view('admin.users.create', compact('units', 'subUnits'));
    }

    /**
     * Simpan akun baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['unit', 'sub_unit'])],
            'unit_id' => ['required', 'exists:unit_usaha,id'],
            'sub_unit_id' => ['nullable', 'exists:sub_unit_usaha,id'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'unit_id.required' => 'Unit usaha wajib dipilih.',
        ]);

        // Validasi tambahan: sub_unit role harus punya sub_unit_id
        if ($validated['role'] === 'sub_unit' && empty($validated['sub_unit_id'])) {
            return back()->withInput()->withErrors(['sub_unit_id' => 'Sub unit wajib dipilih untuk role Sub Unit.']);
        }

        // Cek duplikasi: akun untuk unit/sub_unit yang sama
        $existingQuery = User::where('role', $validated['role']);
        if ($validated['role'] === 'unit') {
            $existingQuery->where('unit_id', $validated['unit_id'])->whereNull('sub_unit_id');
        } else {
            $existingQuery->where('sub_unit_id', $validated['sub_unit_id']);
        }
        if ($existingQuery->exists()) {
            $label = $validated['role'] === 'unit' ? 'unit' : 'sub unit';
            return back()->withInput()->withErrors(['unit_id' => "Sudah ada akun untuk {$label} ini."]);
        }

        // Buat akun
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'unit_id' => $validated['unit_id'],
            'sub_unit_id' => $validated['role'] === 'sub_unit' ? $validated['sub_unit_id'] : null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil dibuat.');
    }

    /**
     * Form edit akun
     */
    public function edit(User $user)
    {
        // Hanya boleh edit akun unit/sub_unit
        if (!in_array($user->role, ['unit', 'sub_unit'])) {
            abort(403, 'Tidak dapat mengedit akun ini.');
        }

        $units = UnitUsaha::where('is_active', true)->orderBy('nama')->get();
        $subUnits = SubUnitUsaha::where('is_active', true)->with('unit')->orderBy('nama')->get();

        return view('admin.users.edit', compact('user', 'units', 'subUnits'));
    }

    /**
     * Update akun
     */
    public function update(Request $request, User $user)
    {
        if (!in_array($user->role, ['unit', 'sub_unit'])) {
            abort(403, 'Tidak dapat mengedit akun ini.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['unit', 'sub_unit'])],
            'unit_id' => ['required', 'exists:unit_usaha,id'],
            'sub_unit_id' => ['nullable', 'exists:sub_unit_usaha,id'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'unit_id.required' => 'Unit usaha wajib dipilih.',
        ]);

        if ($validated['role'] === 'sub_unit' && empty($validated['sub_unit_id'])) {
            return back()->withInput()->withErrors(['sub_unit_id' => 'Sub unit wajib dipilih untuk role Sub Unit.']);
        }

        // Cek duplikasi (kecuali diri sendiri)
        $existingQuery = User::where('role', $validated['role'])->where('id', '!=', $user->id);
        if ($validated['role'] === 'unit') {
            $existingQuery->where('unit_id', $validated['unit_id'])->whereNull('sub_unit_id');
        } else {
            $existingQuery->where('sub_unit_id', $validated['sub_unit_id']);
        }
        if ($existingQuery->exists()) {
            $label = $validated['role'] === 'unit' ? 'unit' : 'sub unit';
            return back()->withInput()->withErrors(['unit_id' => "Sudah ada akun lain untuk {$label} ini."]);
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'unit_id' => $validated['unit_id'],
            'sub_unit_id' => $validated['role'] === 'sub_unit' ? $validated['sub_unit_id'] : null,
        ];

        // Update password hanya jika diisi
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Hapus akun
     */
    public function destroy(User $user)
    {
        if (!in_array($user->role, ['unit', 'sub_unit'])) {
            abort(403, 'Tidak dapat menghapus akun ini.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun \"{$name}\" berhasil dihapus.");
    }

    /**
     * Reset password akun
     */
    public function resetPassword(User $user)
    {
        if (!in_array($user->role, ['unit', 'sub_unit'])) {
            abort(403);
        }

        // Reset ke password default berdasarkan email prefix
        $emailPrefix = explode('@', $user->email)[0];
        $defaultPassword = $emailPrefix . '123';

        $user->update([
            'password' => Hash::make($defaultPassword),
        ]);

        return back()->with('success', "Password akun \"{$user->name}\" berhasil direset ke: {$defaultPassword}");
    }

    /**
     * API: Dapatkan sub units berdasarkan unit_id
     */
    public function getSubUnits(UnitUsaha $unit)
    {
        return response()->json(
            $unit->subUnitUsaha()->where('is_active', true)->orderBy('nama')->get(['id', 'nama', 'kode'])
        );
    }
}
