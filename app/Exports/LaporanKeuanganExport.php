<?php

namespace App\Exports;

use App\Models\LaporanKeuangan;
use App\Models\UnitUsaha;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Export Laporan Keuangan ke Excel
 */
class LaporanKeuanganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected ?int $bulan;
    protected ?int $tahun;
    protected ?int $unitId;
    protected $data;
    protected int $rowNumber = 0;

    public function __construct(?int $bulan = null, ?int $tahun = null, ?int $unitId = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->unitId = $unitId;
    }

    public function collection()
    {
        $query = LaporanKeuangan::with(['unit', 'subUnit']);

        if ($this->tahun) {
            $query->tahun($this->tahun);
        }

        if ($this->bulan) {
            $query->where('bulan', $this->bulan);
        }

        if ($this->unitId) {
            $query->unit($this->unitId);
        }

        $this->data = $query->orderBy('tahun')
                            ->orderBy('bulan')
                            ->orderBy('unit_id')
                            ->orderBy('sub_unit_id')
                            ->get();

        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Periode',
            'Unit Usaha',
            'Sub Unit',
            'Pendapatan (Rp)',
            'Pengeluaran (Rp)',
            'Laba/Rugi (Rp)',
            'Keterangan',
        ];
    }

    public function map($laporan): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $laporan->periode,
            $laporan->unit?->nama ?? '-',
            $laporan->subUnit?->nama ?? '-',
            (float) $laporan->pendapatan,
            (float) $laporan->pengeluaran,
            $laporan->laba_rugi,
            $laporan->keterangan ?? '',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $lastRow = $sheet->getHighestRow();
        $lastCol = 'H';

        // Header styling
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '86AE5F'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Data rows border
        $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ]);

        // Number format for currency columns
        $sheet->getStyle("E2:G{$lastRow}")->getNumberFormat()
              ->setFormatCode('#,##0');

        // Alignment for numbers
        $sheet->getStyle("E2:G{$lastRow}")->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Total row
        if ($lastRow > 1) {
            $totalRow = $lastRow + 1;

            // Hitung total dari data collection (lebih reliable daripada SUM formula)
            $totalPendapatan = $this->data ? $this->data->sum('pendapatan') : 0;
            $totalPengeluaran = $this->data ? $this->data->sum('pengeluaran') : 0;
            $totalLabaRugi = $totalPendapatan - $totalPengeluaran;

            $sheet->setCellValue("A{$totalRow}", '');
            $sheet->setCellValue("B{$totalRow}", '');
            $sheet->setCellValue("C{$totalRow}", '');
            $sheet->setCellValue("D{$totalRow}", 'TOTAL');
            $sheet->setCellValue("E{$totalRow}", $totalPendapatan);
            $sheet->setCellValue("F{$totalRow}", $totalPengeluaran);
            $sheet->setCellValue("G{$totalRow}", $totalLabaRugi);

            $sheet->getStyle("A{$totalRow}:{$lastCol}{$totalRow}")->applyFromArray([
                'font' => ['bold' => true, 'size' => 11],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6'],
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => Border::BORDER_DOUBLE,
                        'color' => ['rgb' => '374151'],
                    ],
                ],
            ]);

            $sheet->getStyle("E{$totalRow}:G{$totalRow}")->getNumberFormat()
                  ->setFormatCode('#,##0');
        }

        return [];
    }

    public function title(): string
    {
        $title = 'Laporan Keuangan';

        if ($this->unitId) {
            $unit = UnitUsaha::find($this->unitId);
            $title .= ' - ' . ($unit?->nama ?? '');
        }

        if ($this->bulan && $this->tahun) {
            $title .= ' ' . (LaporanKeuangan::$namaBulan[$this->bulan] ?? '') . ' ' . $this->tahun;
        } elseif ($this->tahun) {
            $title .= ' Tahun ' . $this->tahun;
        }

        return substr($title, 0, 31); // Excel sheet name max 31 chars
    }
}
