<?php

namespace App\Filament\Resources\MonitorTcs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                TextColumn::make('tgl_monitoring')
                    ->label('Tgl Monitoring')
                    ->date('d/m/Y')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kriteria.mstfasemonitoring.fase_monitoring')
                    ->label('Fase Monitoring')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kriteria.mstfasemonitoring.parameter')
                    ->label('Parameter')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('kriteria.nm_kriteria')
                    ->label('Kriteria')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kriteria.nilai_kriteria')
                    ->label('Nilai Kriteria')
                    ->sortable(),
                TextColumn::make('nilai_monitor')
                    ->label('Nilai Monitor')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->searchable(),
                TextColumn::make('evalusi_monitoring')
                    ->label('Evaluasi')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->toggleable(),
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('tc')
                    ->label('Trace Code')
                    ->relationship('tc', 'tracecode')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('user')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('tgl_monitoring')
                    ->label('Rentang Tanggal')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tgl_monitoring', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tgl_monitoring', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tgl_monitoring', 'desc')
            ->striped();
    }
}
