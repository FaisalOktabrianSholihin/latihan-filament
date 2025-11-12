<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\HasilMonitoring;
use App\Filament\Widgets\RankingTitikKritis;

class Dashboard extends BaseDashboard
{
    // Hapus atau komentari metode getWidgets()
    /*
    protected function getWidgets(): array
    {
        return [
            HasilMonitoring::class,
            RankingTitikKritis::class,
        ];
    }
    */

    /**
     * Gunakan getHeaderWidgets() untuk meletakkan widget di bagian atas dashboard.
     * Atau gunakan getFooterWidgets() untuk meletakkan widget di bagian bawah.
     */
    protected function getHeaderWidgets(): array
    {
        return [
            HasilMonitoring::class,
            RankingTitikKritis::class,
        ];
    }
}
