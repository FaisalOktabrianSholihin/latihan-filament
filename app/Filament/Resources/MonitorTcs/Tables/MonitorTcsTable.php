<?php

namespace App\Filament\Resources\MonitorTcs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class MonitorTcsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_monitor_tc')
                    ->label('ID Monitor')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tc.tracecode')
                    ->label('Trace Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fasemonitoring.fase_monitoring')
                    ->label('Fase Monitoring')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kriteria.nm_kriteria')
                    ->label('Kriteria')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nilai_monitor')
                    ->label('Nilai')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tgl_monitoring')
                    ->label('Tgl Monitoring')
                    ->date('d/m/Y')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('hasil')
                    ->label('Hasil')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Sesuai' => 'success',
                        'Tidak Sesuai' => 'danger',
                        'Perlu Perbaikan' => 'warning',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ket_monitor')
                    ->label('Keterangan')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tgl_update')
                    ->label('Tgl Update')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('evalusi_monitoring')
                    ->label('Evaluasi')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
