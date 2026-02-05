<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Buku Kas Harian - {{ $rekap['periode'] ?? '' }}</title>
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
        .font-bold { font-weight: bold; }
        
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
        
        .col-no { width: 5%; }
        .col-kw { width: 7%; }
        .col-tanggal { width: 9%; }
        .col-uraian { width: 25%; }
        .col-uang { width: 12%; }
        .col-saldo { width: 12%; }
        .col-ket { width: 18%; }
        
        .row-header {
            background: #e8f5e9 !important;
        }
        
        .row-header td {
            font-weight: bold;
            text-align: center;
            color: #2e7d32;
        }
        
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
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                    @endif
                </td>
                <td class="text-cell">
                    <h1>BUKU KAS HARIAN</h1>
                    <h2>Unit Perkebunan Lubuk Malako - BUMNag Madani</h2>
                    <div class="periode">Periode: {{ $periode ?? ($rekap['nama_bulan'] ?? '') . ' ' . ($tahun ?? '') }}</div>
                </td>
                <td class="spacer-cell"></td>
            </tr>
        </table>
    </div>
    
    {{-- Summary --}}
    <div class="summary">
        <table class="summary-table">
            <tr>
                <td class="summary-label">Saldo Awal:</td>
                <td class="summary-value">Rp {{ number_format($rekap['saldo_awal'] ?? 0, 0, ',', '.') }}</td>
                <td class="summary-label">Total Uang Masuk:</td>
                <td class="summary-value text-green">Rp {{ number_format($rekap['total_masuk'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="summary-label">Total Uang Keluar:</td>
                <td class="summary-value text-red">Rp {{ number_format($rekap['total_keluar'] ?? 0, 0, ',', '.') }}</td>
                <td class="summary-label">Saldo Akhir:</td>
                <td class="summary-value font-bold">Rp {{ number_format($rekap['saldo_akhir'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="summary-label">Jumlah Transaksi:</td>
                <td class="summary-value">{{ $rekap['jumlah_transaksi'] ?? 0 }} transaksi</td>
                <td class="summary-label">Selisih (Masuk - Keluar):</td>
                <td class="summary-value {{ ($rekap['selisih'] ?? 0) >= 0 ? 'text-green' : 'text-red' }}">
                    {{ ($rekap['selisih'] ?? 0) >= 0 ? '+' : '' }}Rp {{ number_format($rekap['selisih'] ?? 0, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>
    
    {{-- Data Table --}}
    @if($transaksi->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">NO URUT</th>
                    <th class="col-kw">NO KW</th>
                    <th class="col-tanggal">TANGGAL</th>
                    <th class="col-uraian">URAIAN</th>
                    <th class="col-uang">UANG MASUK (RP)</th>
                    <th class="col-uang">UANG KELUAR (RP)</th>
                    <th class="col-saldo">SALDO (RP)</th>
                    <th class="col-ket">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                {{-- Saldo Awal Row --}}
                <tr class="row-header">
                    <td colspan="4" class="text-center">SALDO AWAL {{ isset($bulan) && $bulan ? 'BULAN' : (isset($tahun) && $tahun ? 'TAHUN' : '') }}</td>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                    <td class="text-center">{{ number_format($rekap['saldo_awal'] ?? 0, 0, ',', '.') }}</td>
                    <td class="text-center">-</td>
                </tr>
                
                @foreach($transaksi as $trx)
                    <tr>
                        <td class="text-center">{{ $trx->no_urut }}</td>
                        <td class="text-center">{{ $trx->no_kwitansi ?? '-' }}</td>
                        <td class="text-center">{{ $trx->tanggal->format('d/m/Y') }}</td>
                        <td class="text-left">{{ $trx->uraian }}</td>
                        <td class="text-right {{ $trx->uang_masuk > 0 ? 'text-green' : '' }}">
                            {{ $trx->uang_masuk > 0 ? number_format($trx->uang_masuk, 0, ',', '.') : '-' }}
                        </td>
                        <td class="text-right {{ $trx->uang_keluar > 0 ? 'text-red' : '' }}">
                            {{ $trx->uang_keluar > 0 ? number_format($trx->uang_keluar, 0, ',', '.') : '-' }}
                        </td>
                        <td class="text-right font-bold">{{ number_format($trx->saldo, 0, ',', '.') }}</td>
                        <td class="text-left">{{ $trx->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
                
                {{-- Total Row --}}
                <tr class="row-total">
                    <td colspan="4" class="text-center">TOTAL</td>
                    <td class="text-right text-green">{{ number_format($rekap['total_masuk'] ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right text-red">{{ number_format($rekap['total_keluar'] ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($rekap['saldo_akhir'] ?? 0, 0, ',', '.') }}</td>
                    <td class="text-center">-</td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="no-data">
            Tidak ada transaksi untuk periode ini.
        </div>
    @endif
    
    {{-- Print Footer --}}
    <div class="print-footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} | BUMNag Madani Lubuk Malako
    </div>
</div>
</body>
</html>
