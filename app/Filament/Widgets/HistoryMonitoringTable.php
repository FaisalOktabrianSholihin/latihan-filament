<?php

namespace App\Filament\Widgets;

use App\Models\MonitorTc;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class HistoryMonitoringTable extends BaseWidget
{
    protected static ?string $heading = 'History Monitoring';

    protected int | string | array $columnSpan = 'full';

    public ?string $traceCode = null;

    protected function getTableQuery(): Builder
    {
        if (!$this->traceCode) {
            return MonitorTc::query()->whereRaw('1 = 0'); // Return empty result
        }

        $tc = \App\Models\Tc::where('tracecode', $this->traceCode)->first();

        if (!$tc) {
            return MonitorTc::query()->whereRaw('1 = 0');
        }

        return MonitorTc::query()
            ->where('id_tc', $tc->id_tc)
            ->with(['kriteria.mstfasemonitoring', 'user', 'tc'])
            ->latest('tgl_monitoring');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('tgl_monitoring')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kriteria.mstfasemonitoring.fase_monitoring')
                    ->label('Fase')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kriteria.mstfasemonitoring.parameter')
                    ->label('Parameter')
                    ->searchable()
                    ->wrap()
                    ->limit(40),
                Tables\Columns\TextColumn::make('kriteria.nm_kriteria')
                    ->label('Kriteria')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kriteria.nilai_kriteria')
                    ->label('Nilai Kriteria')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('nilai_monitor')
                    ->label('Nilai Monitor')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('evalusi_monitoring')
                    ->label('Evaluasi')
                    ->searchable()
                    ->wrap()
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kriteria.mstfasemonitoring.fase_monitoring')
                    ->label('Fase Monitoring')
                    ->relationship('kriteria.mstfasemonitoring', 'fase_monitoring')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('tgl_monitoring', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('30s'); // Auto refresh every 30 seconds
    }

    protected function getTableHeading(): ?string
    {
        return 'History Monitoring - ' . ($this->traceCode ?? 'All');
    }

    protected function getTableDescription(): ?string
    {
        return 'Riwayat monitoring untuk trace code yang dipilih dengan fitur export data.';
    }

    public function exportAllData()
    {
        $records = $this->getTableQuery()->get();

        $filename = 'history-monitoring-' . ($this->traceCode ?? 'all') . '-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Add headers
            fputcsv($file, [
                'Trace Code',
                'Tanggal Monitoring',
                'Fase Monitoring',
                'Parameter',
                'Kriteria',
                'Nilai Kriteria',
                'Nilai Monitor',
                'Evaluasi',
                'User',
                'Tanggal Update',
            ]);

            // Add data
            foreach ($records as $record) {
                fputcsv($file, [
                    $record->tc->tracecode ?? '-',
                    $record->tgl_monitoring ? \Carbon\Carbon::parse($record->tgl_monitoring)->format('d/m/Y H:i') : '-',
                    $record->kriteria->mstfasemonitoring->fase_monitoring ?? '-',
                    $record->kriteria->mstfasemonitoring->parameter ?? '-',
                    $record->kriteria->nm_kriteria ?? '-',
                    $record->kriteria->nilai_kriteria ?? '-',
                    $record->nilai_monitor,
                    $record->evalusi_monitoring ?? '-',
                    $record->user->name ?? 'System',
                    $record->tgl_update ? \Carbon\Carbon::parse($record->tgl_update)->format('d/m/Y H:i') : '-',
                ]);
            }

            fclose($file);
        };

        return \Illuminate\Support\Facades\Response::stream($callback, 200, $headers);
    }
}
