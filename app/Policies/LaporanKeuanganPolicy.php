<?php

namespace App\Policies;

use App\Models\LaporanKeuangan;
use App\Models\User;

/**
 * Policy untuk otorisasi akses Laporan Keuangan
 * 
 * Aturan:
 * - Admin/Super Admin: akses penuh ke semua laporan
 * - Unit: hanya laporan milik unitnya (direct, tanpa sub_unit_id)
 * - Sub Unit: hanya laporan milik sub unitnya
 * - Jika data sudah diinput oleh role lebih tinggi, role lebih rendah tidak bisa edit/hapus
 */
class LaporanKeuanganPolicy
{
    /**
     * Admin bisa melihat semua laporan
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdminLevel() || $user->isUnit() || $user->isSubUnit();
    }

    /**
     * Bisa melihat detail laporan
     */
    public function view(User $user, LaporanKeuangan $laporan): bool
    {
        if ($user->isAdminLevel()) {
            return true;
        }

        if ($user->isUnit()) {
            return $laporan->unit_id === $user->unit_id;
        }

        if ($user->isSubUnit()) {
            return $laporan->sub_unit_id === $user->sub_unit_id;
        }

        return false;
    }

    /**
     * Bisa membuat laporan baru (cek di controller apakah periode sudah ada)
     */
    public function create(User $user): bool
    {
        return $user->isAdminLevel() || $user->isUnit() || $user->isSubUnit();
    }

    /**
     * Bisa mengedit laporan
     * - Admin bisa edit semua
     * - Unit hanya bisa edit laporan direct unitnya (bukan yang created by admin untuk sub-unitnya)
     * - Sub Unit hanya bisa edit laporan sub-unitnya yang dibuat sendiri atau oleh sub-unit itu sendiri
     */
    public function update(User $user, LaporanKeuangan $laporan): bool
    {
        if ($user->isAdminLevel()) {
            return true;
        }

        if ($user->isUnit()) {
            // Unit hanya bisa edit laporan langsung unit (tanpa sub_unit)
            if ($laporan->unit_id !== $user->unit_id || $laporan->sub_unit_id !== null) {
                return false;
            }
            return true;
        }

        if ($user->isSubUnit()) {
            // Sub unit hanya bisa edit laporan miliknya sendiri
            if ($laporan->sub_unit_id !== $user->sub_unit_id) {
                return false;
            }
            // Tidak bisa edit jika diinput oleh admin
            if ($laporan->createdBy && $laporan->createdBy->isAdminLevel()) {
                return false;
            }
            return true;
        }

        return false;
    }

    /**
     * Bisa menghapus laporan
     * Aturan sama dengan update
     */
    public function delete(User $user, LaporanKeuangan $laporan): bool
    {
        return $this->update($user, $laporan);
    }

    /**
     * Cek apakah data sudah diinput oleh role yang lebih tinggi
     * Helper untuk menampilkan info di views
     */
    public static function isInputByHigherRole(User $currentUser, LaporanKeuangan $laporan): bool
    {
        $creator = $laporan->createdBy;
        if (!$creator) {
            return false;
        }

        // Jika current user adalah sub_unit, cek apakah diinput oleh admin atau unit
        if ($currentUser->isSubUnit()) {
            return $creator->isAdminLevel() || $creator->isUnit();
        }

        // Jika current user adalah unit, cek apakah diinput oleh admin
        if ($currentUser->isUnit()) {
            return $creator->isAdminLevel();
        }

        return false;
    }

    /**
     * Mendapatkan pesan siapa yang menginput data
     */
    public static function getInputByMessage(LaporanKeuangan $laporan): ?string
    {
        $creator = $laporan->createdBy;
        if (!$creator) {
            return null;
        }

        $roleLabel = match ($creator->role) {
            'super_admin', 'admin' => 'Admin',
            'unit' => 'Unit ' . ($creator->unitUsaha?->nama ?? ''),
            'sub_unit' => 'Sub Unit ' . ($creator->subUnitUsaha?->nama ?? ''),
            default => null,
        };

        if (!$roleLabel) {
            return null;
        }

        return "Diinput oleh {$roleLabel} ({$creator->name})";
    }
}
