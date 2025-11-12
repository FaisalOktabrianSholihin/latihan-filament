<?php

namespace App\Filament\Widgets;

use App\Models\MstFasemonitor;
use App\Models\Tc;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class MonitoringBiayaTable extends BaseWidget
{
    protected static ?string $heading = 'Monitoring Biaya';

    protected int | string | array $columnSpan = 'full';

    public ?string $traceCode = null;

    protected function getTableQuery(): Builder
    {
        if (!$this->traceCode) {
            return MstFasemonitor::query()->whereRaw('1 = 0');
        }

        return MstFasemonitor::query()
            ->with(['kriteria'])
            ->where('grub_fasemonitor', 'Biaya')
            ->orderBy('fase_monitoring')
            ->orderBy('parameter');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('fase_monitoring')
                    ->label('Fase Monitoring')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parameter')
                    ->label('Parameter')
                    ->searchable()
                    ->wrap()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('titik_kritis')
                    ->label('Titik Kritis')
                    ->searchable()
                    ->wrap()
                    ->badge()
                    ->color('warning')
                    ->default('-')
                    ->placeholder('Tidak ada'),
                Tables\Columns\TextColumn::make('monitoring_poin')
                    ->label('Monitoring Poin')
                    ->searchable()
                    ->wrap()
                    ->limit(50),
                Tables\Columns\TextColumn::make('kriteria_count')
                    ->label('Jumlah Kriteria')
                    ->counts('kriteria')
                    ->badge()
                    ->color('success')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('grub_fasemonitor')
                    ->label('Grup')
                    ->badge()
                    ->color('primary')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('fase_monitoring')
                    ->label('Fase Monitoring')
                    ->options(function () {
                        return MstFasemonitor::where('grub_fasemonitor', 'Biaya')
                            ->distinct()
                            ->pluck('fase_monitoring', 'fase_monitoring');
                    })
                    ->searchable(),
            ])
            ->defaultSort('fase_monitoring', 'asc')
            ->striped()
            ->paginated([10, 25, 50])
            ->poll('60s');
    }

    protected function getTableHeading(): ?string
    {
        return 'Monitoring Biaya - ' . ($this->traceCode ?? 'All');
    }

    protected function getTableDescription(): ?string
    {
        return 'Daftar parameter monitoring untuk aspek biaya.';
    }
}
