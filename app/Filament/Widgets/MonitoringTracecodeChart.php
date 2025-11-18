<?php

namespace App\Filament\Widgets;

use App\Models\Tc;
use App\Models\MonitorTc;
use Filament\Widgets\ChartWidget;

class MonitoringTracecodeChart extends ChartWidget
{
    protected ?string $heading = 'Monitoring Tracecode';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        // Hitung TC yang sudah selesai monitoring (status sudah dan ada data monitoring)
        $tcSudahSelesai = Tc::where('status', 'sudah')
            ->whereHas('monitorTc', function ($query) {
                $query->whereNotNull('nilai_monitor');
            })
            ->count();

        // Hitung TC yang perlu tindakan (status sudah tapi belum ada monitoring atau belum lengkap)
        $tcPerluTindakan = Tc::where('status', 'sudah')
            ->whereDoesntHave('monitorTc', function ($query) {
                $query->whereNotNull('nilai_monitor');
            })
            ->count();

        // Tambahkan TC yang belum dimonitoring sama sekali
        $tcBelum = Tc::where('status', 'belum')->count();
        $tcPerluTindakan += $tcBelum;

        // Hitung persentase
        $total = $tcSudahSelesai + $tcPerluTindakan;
        $persenSudah = $total > 0 ? round(($tcSudahSelesai / $total) * 100) : 0;
        $persenPerlu = $total > 0 ? round(($tcPerluTindakan / $total) * 100) : 0;

        return [
            'datasets' => [
                [
                    'label' => 'Monitoring Tracecode',
                    'data' => [$persenSudah, $persenPerlu],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)', // green untuk sudah selesai
                        'rgb(239, 68, 68)',  // red untuk perlu tindakan
                    ],
                ],
            ],
            'labels' => [
                "TC Sudah Selesai ({$persenSudah}%)",
                "TC Perlu Tindakan ({$persenPerlu}%)",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
