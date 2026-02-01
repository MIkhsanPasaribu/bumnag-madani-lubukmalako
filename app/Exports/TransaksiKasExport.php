<?php

namespace App\Exports;

use App\Models\TransaksiKas;
use App\Models\ProfilBumnag;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * Export Transaksi Kas ke Excel
 */
class TransaksiKasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths, ShouldAutoSize
{
    protected int $bulan;
    protected int $tahun;

    public function __construct(int $bulan, int $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return TransaksiKas::with('kategori')
            ->bulan($this->bulan, $this->tahun)
            ->urut()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No Urut',
            'No Kwitansi',
            'Tanggal',
            'Uraian',
            'Kategori',
            'Uang Masuk',
            'Uang Keluar',
            'Saldo',
            'Keterangan',
        ];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->no_urut,
            $transaksi->no_kwitansi ?? '-',
            $transaksi->tanggal->format('d/m/Y'),
            $transaksi->uraian,
            $transaksi->kategori?->nama ?? '-',
            $transaksi->uang_masuk,
            $transaksi->uang_keluar,
            $transaksi->saldo,
            $transaksi->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '86ae5f'],
            ],
            'alignment' => ['horizontal' => 'center'],
        ]);

        // Number format for currency columns
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("F2:H{$lastRow}")->getNumberFormat()
            ->setFormatCode('#,##0');

        // Alternate row colors
        for ($i = 2; $i <= $lastRow; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle("A{$i}:I{$i}")->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F9FAFB'],
                    ],
                ]);
            }
        }

        return [];
    }

    public function title(): string
    {
        return TransaksiKas::$namaBulan[$this->bulan] . ' ' . $this->tahun;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 15,
            'C' => 12,
            'D' => 40,
            'E' => 18,
            'F' => 18,
            'G' => 18,
            'H' => 18,
            'I' => 25,
        ];
    }
}
