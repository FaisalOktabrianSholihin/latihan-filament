<?php

namespace App\Filament\Widgets;

use App\Models\MonitorTc;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class HasilMonitoring extends BaseWidget
{
    protected static ?string $heading = 'Hasil Monitoring per Trace Code';

    protected function getTableQuery(): Builder
    {
        return MonitorTc::query()
            ->with(['tc', 'mstfasemonitoring'])
            ->latest('tgl_update');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('tc.tracecode')->label('Trace Code')->sortable(),
            Tables\Columns\TextColumn::make('mstfasemonitoring.fase_monitoring')->label('Fase Monitoring')->sortable(),
            Tables\Columns\TextColumn::make('mstfasemonitoring.parameter')->label('Parameter'),
            Tables\Columns\TextColumn::make('mstfasemonitoring.titik_kritis')->label('Titik Kritis'),
            Tables\Columns\TextColumn::make('nilai_monitor')->label('Nilai Monitoring'),
            Tables\Columns\TextColumn::make('hasil')->label('Hasil Evaluasi'),
            Tables\Columns\TextColumn::make('tgl_update')->label('Tanggal Update')->date(),
        ];
    }
}
