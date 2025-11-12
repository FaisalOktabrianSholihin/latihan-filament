<?php

namespace App\Filament\Widgets;

use App\Models\MstFasemonitor;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RankingTitikKritis extends BaseWidget
{
    protected static ?string $heading = 'Ranking Titik Kritis';

    protected function getTableQuery(): Builder
    {
        return MstFasemonitor::query()
            ->with('kriterias')
            ->orderByDesc('bobot');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('fase_monitoring')->label('Fase'),
            Tables\Columns\TextColumn::make('parameter')->label('Parameter'),
            Tables\Columns\TextColumn::make('titik_kritis')->label('Titik Kritis'),
            Tables\Columns\TextColumn::make('bobot')->label('Bobot')->sortable(),
            Tables\Columns\TextColumn::make('kriterias.nm_kriteria')->label('Kriteria'),
            Tables\Columns\TextColumn::make('kriterias.nilai_kriteria')->label('Nilai Kriteria'),
        ];
    }
}
