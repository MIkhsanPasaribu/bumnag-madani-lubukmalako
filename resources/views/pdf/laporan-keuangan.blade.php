<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Keuangan - {{ $rekap['periode'] ?? '' }}</title>
    <style>
        @page {
            margin: 15mm 20mm 15mm 20mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }
        
        .container {
            padding: 0 10px;
        }
        
        /* Header Table Layout */
        .header {
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #86ae5f;
        }
        
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .header-table td {
            vertical-align: middle;
            padding: 5px;
        }
        
        .logo-cell {
            width: 120px;
            text-align: left;
        }
        
        .logo-cell img {
            width: 100px;
            height: auto;
        }
        
        .text-cell {
            text-align: center;
        }
        
        .text-cell h1 {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .text-cell h2 {
            font-size: 12px;
            font-weight: bold;
            color: #555;
            margin: 0 0 5px 0;
        }
        
        .text-cell p {
            font-size: 9px;
            color: #777;
            margin: 0 0 8px 0;
        }
        
        .text-cell .periode {
            font-size: 11px;
            color: #86ae5f;
            font-weight: bold;
            text-transform: uppercase;
            padding: 4px 15px;
            border: 1px solid #86ae5f;
            display: inline-block;
            border-radius: 20px;
        }
        
        .unit-badge {
            display: inline-block;
            background: #86ae5f;
            color: #fff;
            padding: 3px 12px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            margin-top: 6px;
        }
        
        .spacer-cell {
            width: 120px;
        }
        
        /* Footer */
        .print-footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8px;
            color: #888;
        }
        
        /* Summary Section */
        .summary {
            margin-bottom: 15px;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .summary-table td {
            padding: 5px 8px;
            font-size: 9px;
            vertical-align: top;
        }
        
        .summary-label {
            font-weight: bold;
            color: #333;
            width: 18%;
        }
        
        .summary-value {
            width: 32%;
        }
        
        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }
        .text-blue { color: #2563eb; }
        .font-bold { font-weight: bold; }
        
        /* Section title */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #374151;
            background: #f0fdf4;
            padding: 5px 8px;
            border-left: 3px solid #86ae5f;
            margin: 12px 0 8px 0;
        }
        
        /* Data Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }
        
        table.data-table th {
            background: #86ae5f;
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 8px 5px;
            font-size: 8px;
            border: 1px solid #6b9a45;
            text-transform: uppercase;
        }
        
        table.data-table td {
            border: 1px solid #ddd;
            padding: 5px 4px;
            font-size: 8px;
            vertical-align: middle;
        }
        
        table.data-table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        
        /* Column widths - Rekap Unit */
        .col-unit { width: 30%; }
        .col-pendapatan-u { width: 23%; }
        .col-pengeluaran-u { width: 23%; }
        .col-laba-u { width: 24%; }
        
        /* Column widths - Detail */
        .col-no { width: 4%; }
        .col-periode { width: 11%; }
        .col-unit-d { width: 12%; }
        .col-subunit { width: 12%; }
        .col-pendapatan { width: 13%; }
        .col-pengeluaran { width: 13%; }
        .col-laba { width: 12%; }
        .col-ket { width: 23%; }
        
        .row-total {
            background: #e8f5e9 !important;
        }
        
        .row-total td {
            font-weight: bold;
        }
        
        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
<div class="container">
    {{-- Header with Table Layout --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    @if(file_exists($logoPath ?? public_path('images/logo.png')))
                        <img src="{{ $logoPath ?? public_path('images/logo.png') }}" alt="Logo">
                    @endif
                </td>
                <td class="text-cell">
                    <h1>LAPORAN KEUANGAN</h1>
                    <h2>BUMNag Madani Lubuk Malako</h2>
                    <p>Nagari Lubuk Malako, Kecamatan Sangir Jujuan, Kabupaten Solok Selatan</p>
                    <div class="periode">Periode: {{ $rekap['periode'] ?? '-' }}</div>
                    @if($rekap['unit_nama'] ?? false)
                        <br><span class="unit-badge">{{ $rekap['unit_nama'] }}</span>
                    @endif
                </td>
                <td class="spacer-cell"></td>
            </tr>
        </table>
    </div>
    
    {{-- Summary --}}
    <div class="summary">
        <table class="summary-table">
            <tr>
                <td class="summary-label">Total Pendapatan:</td>
                <td class="summary-value text-green font-bold">Rp {{ number_format($rekap['total_pendapatan'], 0, ',', '.') }}</td>
                <td class="summary-label">Total Pengeluaran:</td>
                <td class="summary-value text-red font-bold">Rp {{ number_format($rekap['total_pengeluaran'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="summary-label">Laba / Rugi:</td>
                <td class="summary-value {{ $rekap['total_laba_rugi'] >= 0 ? 'text-blue' : 'text-red' }} font-bold">
                    {{ $rekap['total_laba_rugi'] >= 0 ? '+' : '-' }}Rp {{ number_format(abs($rekap['total_laba_rugi']), 0, ',', '.') }}
                </td>
                <td class="summary-label">Jumlah Entri:</td>
                <td class="summary-value">{{ $laporan->count() }} laporan</td>
            </tr>
        </table>
    </div>
    
    {{-- Rekap Per Unit (jika lebih dari 1 unit) --}}
    @if(count($rekapPerUnit) > 1)
    <table class="data-table">
        <thead>
            <tr>
                <th class="col-unit">Unit Usaha</th>
                <th class="col-pendapatan-u">Pendapatan</th>
                <th class="col-pengeluaran-u">Pengeluaran</th>
                <th class="col-laba-u">Laba/Rugi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapPerUnit as $unitRekap)
            <tr>
                <td class="text-left">{{ $unitRekap['nama_unit'] }}</td>
                <td class="text-right">Rp {{ number_format($unitRekap['total_pendapatan'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($unitRekap['total_pengeluaran'], 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: {{ $unitRekap['total_laba_rugi'] >= 0 ? '#16a34a' : '#dc2626' }}">
                    Rp {{ number_format(abs($unitRekap['total_laba_rugi']), 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    
    {{-- Detail Data --}}
    @if($laporan->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">NO</th>
                    <th class="col-periode">PERIODE</th>
                    <th class="col-unit-d">UNIT USAHA</th>
                    <th class="col-subunit">SUB UNIT</th>
                    <th class="col-pendapatan">PENDAPATAN</th>
                    <th class="col-pengeluaran">PENGELUARAN</th>
                    <th class="col-laba">LABA/RUGI</th>
                    <th class="col-ket">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $item->periode }}</td>
                        <td class="text-left">{{ $item->unit?->nama ?? '-' }}</td>
                        <td class="text-left">{{ $item->subUnit?->nama ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format($item->pendapatan, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
                        <td class="text-right font-bold" style="color: {{ $item->laba_rugi >= 0 ? '#16a34a' : '#dc2626' }}">
                            Rp {{ number_format(abs($item->laba_rugi), 0, ',', '.') }}
                        </td>
                        <td class="text-left">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
                
                {{-- Total Row --}}
                <tr class="row-total">
                    <td colspan="4" class="text-center">TOTAL</td>
                    <td class="text-right">Rp {{ number_format($rekap['total_pendapatan'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($rekap['total_pengeluaran'], 0, ',', '.') }}</td>
                    <td class="text-right" style="color: {{ $rekap['total_laba_rugi'] >= 0 ? '#16a34a' : '#dc2626' }}">
                        Rp {{ number_format(abs($rekap['total_laba_rugi']), 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="no-data">
            Tidak ada data untuk periode ini.
        </div>
    @endif
    
    {{-- Print Footer --}}
    <div class="print-footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }} WIB &bull; BUMNag Madani Lubuk Malako &bull; Dokumen ini digenerate secara otomatis
    </div>
</div>
</body>
</html>
