<?php

namespace App\Http\Requests;

use App\Models\LaporanKeuangan;
use App\Models\SubUnitUsaha;
use App\Models\UnitUsaha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * Form Request untuk validasi Laporan Keuangan
 * Digunakan oleh Admin, Unit, dan SubUnit controllers
 */
class LaporanKeuanganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2099',
            'pendapatan' => 'required|numeric|min:0|max:999999999999.99',
            'pengeluaran' => 'required|numeric|min:0|max:999999999999.99',
            'keterangan' => 'nullable|string|max:1000',
        ];

        // Admin perlu pilih unit dan sub unit
        if ($this->isAdminContext()) {
            $rules['unit_id'] = 'required|exists:unit_usaha,id';
            $rules['sub_unit_id'] = 'nullable|exists:sub_unit_usaha,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'unit_id.required' => 'Unit usaha wajib dipilih.',
            'unit_id.exists' => 'Unit usaha tidak valid.',
            'sub_unit_id.exists' => 'Sub unit usaha tidak valid.',
            'bulan.required' => 'Bulan wajib dipilih.',
            'bulan.integer' => 'Bulan harus berupa angka.',
            'bulan.min' => 'Bulan tidak valid.',
            'bulan.max' => 'Bulan tidak valid.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal 2020.',
            'tahun.max' => 'Tahun maksimal 2099.',
            'pendapatan.required' => 'Nominal pendapatan wajib diisi.',
            'pendapatan.numeric' => 'Pendapatan harus berupa angka.',
            'pendapatan.min' => 'Pendapatan tidak boleh negatif.',
            'pendapatan.max' => 'Nominal pendapatan terlalu besar.',
            'pengeluaran.required' => 'Nominal pengeluaran wajib diisi.',
            'pengeluaran.numeric' => 'Pengeluaran harus berupa angka.',
            'pengeluaran.min' => 'Pengeluaran tidak boleh negatif.',
            'pengeluaran.max' => 'Nominal pengeluaran terlalu besar.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
        ];
    }

    /**
     * Validasi tambahan setelah rules dasar
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            // Validasi khusus admin: unit + sub_unit konsistensi
            if ($this->isAdminContext()) {
                $this->validateUnitSubUnitConsistency($validator);
            }

            // Validasi duplikat periode
            $this->validateDuplicatePeriode($validator);
        });
    }

    /**
     * Validasi konsistensi unit dan sub unit (admin context)
     */
    private function validateUnitSubUnitConsistency(Validator $validator): void
    {
        $unitId = $this->input('unit_id');
        $subUnitId = $this->input('sub_unit_id');

        $unit = UnitUsaha::find($unitId);
        if (!$unit) {
            return;
        }

        // Unit yang punya sub unit harus pilih sub unit
        if ($unit->hasSubUnits() && empty($subUnitId)) {
            $validator->errors()->add(
                'sub_unit_id',
                'Sub unit wajib dipilih untuk ' . $unit->nama . '.'
            );
            return;
        }

        // Sub unit harus milik unit yang dipilih
        if (!empty($subUnitId)) {
            $subUnit = SubUnitUsaha::find($subUnitId);
            if ($subUnit && $subUnit->unit_id != $unitId) {
                $validator->errors()->add(
                    'sub_unit_id',
                    'Sub unit tidak sesuai dengan unit yang dipilih.'
                );
            }
        }
    }

    /**
     * Validasi duplikat periode (cek apakah data sudah ada)
     */
    private function validateDuplicatePeriode(Validator $validator): void
    {
        $unitId = $this->getEffectiveUnitId();
        $subUnitId = $this->getEffectiveSubUnitId();
        $bulan = (int) $this->input('bulan');
        $tahun = (int) $this->input('tahun');

        if (!$unitId || !$bulan || !$tahun) {
            return;
        }

        $query = LaporanKeuangan::where('unit_id', $unitId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun);

        if ($subUnitId) {
            $query->where('sub_unit_id', $subUnitId);
        } else {
            $query->whereNull('sub_unit_id');
        }

        // Exclude current record saat update
        $currentId = $this->route('laporan_keuangan')?->id
            ?? $this->route('laporan_keuangan');
        if ($currentId) {
            $recordId = is_object($currentId) ? $currentId->id : $currentId;
            $query->where('id', '!=', $recordId);
        }

        $existing = $query->with('createdBy')->first();

        if ($existing) {
            $periode = LaporanKeuangan::$namaBulan[$bulan] . ' ' . $tahun;
            $creatorInfo = $this->getCreatorInfo($existing);

            $validator->errors()->add(
                'bulan',
                "Laporan untuk periode {$periode} sudah ada. {$creatorInfo}"
            );
        }
    }

    /**
     * Mendapatkan informasi siapa yang menginput data yang sudah ada
     */
    private function getCreatorInfo(LaporanKeuangan $existing): string
    {
        $creator = $existing->createdBy;
        if (!$creator) {
            return 'Silakan edit laporan yang ada.';
        }

        $roleLabel = match ($creator->role) {
            'super_admin', 'admin' => 'Admin',
            'unit' => 'akun Unit ' . ($creator->unitUsaha?->nama ?? ''),
            'sub_unit' => 'akun Sub Unit ' . ($creator->subUnitUsaha?->nama ?? ''),
            default => 'pengguna lain',
        };

        return "Data sudah diinputkan oleh {$roleLabel} ({$creator->name}).";
    }

    /**
     * Mendapatkan unit_id efektif berdasarkan context
     */
    public function getEffectiveUnitId(): ?int
    {
        if ($this->isAdminContext()) {
            return $this->input('unit_id') ? (int) $this->input('unit_id') : null;
        }

        /** @var \App\Models\User $user */
        $user = $this->user();

        if ($user->isUnit()) {
            return $user->unit_id;
        }

        if ($user->isSubUnit()) {
            return $user->unit_id;
        }

        return null;
    }

    /**
     * Mendapatkan sub_unit_id efektif berdasarkan context
     */
    public function getEffectiveSubUnitId(): ?int
    {
        if ($this->isAdminContext()) {
            $unitId = $this->input('unit_id');
            $subUnitId = $this->input('sub_unit_id');

            if ($unitId) {
                $unit = UnitUsaha::find($unitId);
                if ($unit && !$unit->hasSubUnits()) {
                    return null;
                }
            }

            return $subUnitId ? (int) $subUnitId : null;
        }

        /** @var \App\Models\User $user */
        $user = $this->user();

        if ($user->isSubUnit()) {
            return $user->sub_unit_id;
        }

        // Unit tanpa sub unit → null
        return null;
    }

    /**
     * Cek apakah request dalam admin context
     */
    private function isAdminContext(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = $this->user();
        return $user && $user->isAdminLevel();
    }
}
