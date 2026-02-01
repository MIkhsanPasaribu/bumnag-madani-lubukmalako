<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widget Statistik - BUMNag Madani</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #fffaed 0%, #fff 100%);
            min-height: 100vh;
            padding: 16px;
        }
        
        .widget-container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .widget-header {
            background: linear-gradient(135deg, #86ae5f 0%, #6b9a45 100%);
            color: white;
            padding: 16px 20px;
            text-align: center;
        }
        
        .widget-header h3 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .widget-header .year {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .widget-body {
            padding: 16px;
        }
        
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .stat-card {
            background: #f9fafb;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
        }
        
        .stat-card.full-width {
            grid-column: span 2;
            background: linear-gradient(135deg, #86ae5f10 0%, #86ae5f05 100%);
            border: 1px solid #86ae5f30;
        }
        
        .stat-label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-value {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
        }
        
        .stat-value.green {
            color: #86ae5f;
        }
        
        .stat-value.red {
            color: #b71e42;
        }
        
        .stat-value.primary {
            color: #86ae5f;
            font-size: 20px;
        }
        
        .widget-footer {
            background: #f9fafb;
            padding: 12px 16px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .widget-footer a {
            color: #86ae5f;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
        }
        
        .widget-footer a:hover {
            text-decoration: underline;
        }
        
        .powered-by {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="widget-container">
        <div class="widget-header">
            <h3>📊 BUMNag Madani Lubuk Malako</h3>
            <span class="year">Statistik Keuangan {{ $stats['tahun'] }}</span>
        </div>
        
        <div class="widget-body">
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-label">Pendapatan</div>
                    <div class="stat-value green">Rp {{ number_format($stats['pendapatan'] / 1000000, 1) }}jt</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Pengeluaran</div>
                    <div class="stat-value red">Rp {{ number_format($stats['pengeluaran'] / 1000000, 1) }}jt</div>
                </div>
                <div class="stat-card full-width">
                    <div class="stat-label">Laba/Rugi Bersih</div>
                    <div class="stat-value primary">
                        {{ $stats['laba'] >= 0 ? '+' : '' }}Rp {{ number_format($stats['laba'] / 1000000, 1) }}jt
                    </div>
                </div>
            </div>
        </div>
        
        <div class="widget-footer">
            <a href="{{ route('transparansi') }}" target="_blank">Lihat Laporan Lengkap →</a>
            <div class="powered-by">Powered by BUMNag Madani</div>
        </div>
    </div>
</body>
</html>
