<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Monitoring</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10pt;
        }

        .info-section {
            margin-bottom: 20px;
            border: 1px solid #000;
            padding: 10px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }

        .info-label {
            display: table-cell;
            width: 20%;
            font-weight: bold;
            padding: 3px 5px;
        }

        .info-value {
            display: table-cell;
            width: 30%;
            padding: 3px 5px;
            border-bottom: 1px dotted #666;
        }

        .section-title {
            font-weight: bold;
            font-size: 12pt;
            margin-top: 20px;
            margin-bottom: 10px;
            padding: 5px;
            background-color: #f0f0f0;
            border-left: 4px solid #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th {
            background-color: #4472C4;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #2E5C9A;
        }

        table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Hasil Monitoring</h1>
        <p>by (Kaling Aktif)</p>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">TC:</div>
            <div class="info-value">{{ $tc->tracecode ?? '-' }}</div>
            <div class="info-label">Komoditi:</div>
            <div class="info-value">{{ $tc->komoditi->nm_komoditi ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">TDK TC:</div>
            <div class="info-value">{{ $tc->tdk_tc ?? '-' }}</div>
            <div class="info-label">Luas Tanam:</div>
            <div class="info-value">{{ $tc->luas_tanam ? number_format((float) $tc->luas_tanam, 2) . ' ha' : '-' }}
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Tanam:</div>
            <div class="info-value">{{ $tc->tgl_tanam ? \Carbon\Carbon::parse($tc->tgl_tanam)->format('d/m/Y') : '-' }}
            </div>
            <div class="info-label">Wilayah TC:</div>
            <div class="info-value">{{ $tc->wilayah_tc ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jumlah Bedeng:</div>
            <div class="info-value">{{ $tc->jumlah_bedeng ?? '-' }}</div>
            <div class="info-label">Budidaya:</div>
            <div class="info-value">{{ $tc->budidaya->nm_budidaya ?? '-' }}</div>
        </div>
    </div>

    @if (count($dataBiaya) > 0)
        <div class="section-title">Biaya</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Fase Monitoring</th>
                    <th style="width: 30%;">Parameter</th>
                    <th style="width: 10%;">Bobot</th>
                    <th style="width: 10%;">Nilai Kriteria</th>
                    <th style="width: 10%;">Nilai Monitor</th>
                    <th style="width: 10%;">Hasil</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataBiaya as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->fasemonitoring->fase_monitoring ?? '-' }}</td>
                        <td>{{ $item->fasemonitoring->parameter ?? '-' }}</td>
                        <td class="text-right">
                            {{ $item->fasemonitoring->bobot ? number_format((float) $item->fasemonitoring->bobot, 2) : '-' }}
                        </td>
                        <td class="text-right">
                            {{ $item->kriteria->nilai_kriteria ? number_format((float) $item->kriteria->nilai_kriteria, 2) : '-' }}
                        </td>
                        <td class="text-right">
                            {{ $item->nilai_monitor ? number_format((float) $item->nilai_monitor, 2) : '-' }}</td>
                        <td class="text-right">{{ $item->hasil ? number_format((float) $item->hasil, 2) : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if (count($dataTeknis) > 0)
        <div class="section-title">Teknis</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Fase Monitoring</th>
                    <th style="width: 30%;">Parameter</th>
                    <th style="width: 10%;">Bobot</th>
                    <th style="width: 10%;">Nilai Kriteria</th>
                    <th style="width: 10%;">Nilai Monitor</th>
                    <th style="width: 10%;">Hasil</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataTeknis as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->fasemonitoring->fase_monitoring ?? '-' }}</td>
                        <td>{{ $item->fasemonitoring->parameter ?? '-' }}</td>
                        <td class="text-right">
                            {{ $item->fasemonitoring->bobot ? number_format((float) $item->fasemonitoring->bobot, 2) : '-' }}
                        </td>
                        <td class="text-right">
                            {{ $item->kriteria->nilai_kriteria ? number_format((float) $item->kriteria->nilai_kriteria, 2) : '-' }}
                        </td>
                        <td class="text-right">
                            {{ $item->nilai_monitor ? number_format((float) $item->nilai_monitor, 2) : '-' }}</td>
                        <td class="text-right">{{ $item->hasil ? number_format((float) $item->hasil, 2) : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>

</html>
