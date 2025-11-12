<?php

namespace App\Filament\Widgets;

use App\Models\MonitorTc;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class HasilMonitoring extends BaseWidget
{
    protected static ?string $heading = 'Hasil Monitoring per Trace Code';

    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return MonitorTc::query()
            ->with(['tc', 'kriteria.mstfasemonitoring', 'user'])
            ->latest('tgl_monitoring');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('tc.tracecode')
                    ->label('Trace Code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_monitoring')
                    ->label('Tanggal Monitoring')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kriteria.mstfasemonitoring.fase_monitoring')
                    ->label('Fase Monitoring')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('kriteria.mstfasemonitoring.parameter')
                    ->label('Parameter')
                    ->searchable()
                    ->wrap()
                    ->limit(40),
                Tables\Columns\TextColumn::make('kriteria.nm_kriteria')
                    ->label('Kriteria')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kriteria.nilai_kriteria')
                    ->label('Nilai Kriteria')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('nilai_monitor')
                    ->label('Nilai Monitoring')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('evalusi_monitoring')
                    ->label('Evaluasi')
                    ->wrap()
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_update')
                    ->label('Update Terakhir')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tc')
                    ->label('Trace Code')
                    ->relationship('tc', 'tracecode')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('tgl_monitoring')
                    ->form([
                        DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        DatePicker::make('until')
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
            ->defaultSort('tgl_monitoring', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }
}
