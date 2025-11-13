<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\MonitoringTracecodeChart;
use App\Filament\Widgets\StatusTcTable;

class Dashboard extends BaseDashboard
{
    /**
     * Widget untuk dashboard
     */
    protected function getHeaderWidgets(): array
    {
        return [
            MonitoringTracecodeChart::class,
            StatusTcTable::class,
        ];
    }
}
