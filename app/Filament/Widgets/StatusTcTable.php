<?php

namespace App\Filament\Widgets;

use App\Models\Tc;
use App\Models\MonitorTc;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class StatusTcTable extends BaseWidget
{
    protected static ?string $heading = 'Status';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tc::query()->with(['monitorTc' => function ($query) {
                    $query->whereNotNull('nilai_monitor');
                }])->orderBy('created_at', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('tracecode')
                    ->label('Trace Code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sudah' => 'success',
                        'belum' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sudah' => 'Sudah Terdaftar',
                        'belum' => 'Belum Terdaftar',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->getStateUsing(function (Tc $record): string {
                        if ($record->status === 'belum') {
                            return 'Belum ada monitoring';
                        }

                        // Hitung berapa banyak parameter yang sudah diisi
                        $totalMonitoring = $record->monitorTc()->count();
                        $monitoringTerisi = $record->monitorTc()
                            ->whereNotNull('nilai_monitor')
                            ->count();

                        if ($monitoringTerisi === 0) {
                            return 'Perlu Tindakan - Belum ada data monitoring';
                        }

                        if ($monitoringTerisi < $totalMonitoring) {
                            return "Dalam Proses - {$monitoringTerisi}/{$totalMonitoring} parameter terisi";
                        }

                        return 'Selesai - Semua parameter sudah terisi';
                    })
                    ->wrap()
                    ->badge()
                    ->color(function (Tc $record): string {
                        if ($record->status === 'belum') {
                            return 'gray';
                        }

                        $totalMonitoring = $record->monitorTc()->count();
                        $monitoringTerisi = $record->monitorTc()
                            ->whereNotNull('nilai_monitor')
                            ->count();

                        if ($monitoringTerisi === 0) {
                            return 'danger';
                        }

                        if ($monitoringTerisi < $totalMonitoring) {
                            return 'warning';
                        }

                        return 'success';
                    }),
            ])
            ->paginated([10, 25, 50])
            ->poll('30s');
    }
}
