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
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * Export Transaksi Kas ke Excel
 * 
 * Mode:
 * - Bulanan: bulan + tahun (default)
 * - Tahunan: tahun saja (bulan = null)
 * - Semua: bulan = null, tahun = null
 */
class TransaksiKasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths, ShouldAutoSize, WithEvents
{
    protected ?int $bulan;
    protected ?int $tahun;
    protected string $mode;
    protected array $rekap;

    public function __construct(?int $bulan = null, ?int $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        
        // Determine mode
        if ($bulan && $tahun) {
            $this->mode = 'bulanan';
        } elseif ($tahun && !$bulan) {
            $this->mode = 'tahunan';
        } else {
            $this->mode = 'semua';
        }
        
        // Calculate rekap
        $this->calculateRekap();
    }

    /**
     * Calculate rekap for footer
     */
    protected function calculateRekap(): void
    {
        $query = TransaksiKas::query();
        
        if ($this->mode === 'bulanan') {
            $query->bulan($this->bulan, $this->tahun);
            $this->rekap = TransaksiKas::getRekapBulanan($this->bulan, $this->tahun);
        } elseif ($this->mode === 'tahunan') {
            $data = TransaksiKas::tahun($this->tahun)->get();
            $this->rekap = [
                'periode' => 'Tahun ' . $this->tahun,
                'jumlah_transaksi' => $data->count(),
                'total_masuk' => $data->sum('uang_masuk'),
                'total_keluar' => $data->sum('uang_keluar'),
                'saldo_awal' => TransaksiKas::getSaldoAwalBulan(1, $this->tahun),
                'saldo_akhir' => TransaksiKas::tahun($this->tahun)->orderBy('tanggal', 'desc')->orderBy('no_urut', 'desc')->value('saldo') ?? 0,
            ];
        } else {
            $data = TransaksiKas::all();
            $lastTrx = TransaksiKas::orderBy('tanggal', 'desc')->orderBy('no_urut', 'desc')->first();
            $this->rekap = [
                'periode' => 'Semua Data',
                'jumlah_transaksi' => $data->count(),
                'total_masuk' => $data->sum('uang_masuk'),
                'total_keluar' => $data->sum('uang_keluar'),
                'saldo_awal' => 0,
                'saldo_akhir' => $lastTrx?->saldo ?? 0,
            ];
        }
    }

    public function collection()
    {
        $query = TransaksiKas::with('kategori');
        
        if ($this->mode === 'bulanan') {
            $query->bulan($this->bulan, $this->tahun);
        } elseif ($this->mode === 'tahunan') {
            $query->tahun($this->tahun);
        }
        
        return $query->urut()->get();
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                
                // Add summary rows at the bottom
                $summaryRow = $lastRow + 2;
                
                // Summary header
                $sheet->setCellValue("A{$summaryRow}", 'REKAP ' . strtoupper($this->rekap['periode'] ?? ''));
                $sheet->mergeCells("A{$summaryRow}:E{$summaryRow}");
                $sheet->getStyle("A{$summaryRow}")->getFont()->setBold(true);
                
                // Summary data
                $summaryRow++;
                $sheet->setCellValue("A{$summaryRow}", 'Jumlah Transaksi:');
                $sheet->setCellValue("B{$summaryRow}", $this->rekap['jumlah_transaksi'] ?? 0);
                
                $summaryRow++;
                $sheet->setCellValue("A{$summaryRow}", 'Total Uang Masuk:');
                $sheet->setCellValue("B{$summaryRow}", $this->rekap['total_masuk'] ?? 0);
                $sheet->getStyle("B{$summaryRow}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("B{$summaryRow}")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('00AA00'));
                
                $summaryRow++;
                $sheet->setCellValue("A{$summaryRow}", 'Total Uang Keluar:');
                $sheet->setCellValue("B{$summaryRow}", $this->rekap['total_keluar'] ?? 0);
                $sheet->getStyle("B{$summaryRow}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("B{$summaryRow}")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('DD0000'));
                
                $summaryRow++;
                $sheet->setCellValue("A{$summaryRow}", 'Saldo Akhir:');
                $sheet->setCellValue("B{$summaryRow}", $this->rekap['saldo_akhir'] ?? 0);
                $sheet->getStyle("B{$summaryRow}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("A{$summaryRow}:B{$summaryRow}")->getFont()->setBold(true);
            },
        ];
    }

    public function title(): string
    {
        if ($this->mode === 'bulanan') {
            return TransaksiKas::$namaBulan[$this->bulan] . ' ' . $this->tahun;
        } elseif ($this->mode === 'tahunan') {
            return 'Tahun ' . $this->tahun;
        }
        return 'Semua Data';
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
