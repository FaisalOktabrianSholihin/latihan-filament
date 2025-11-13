<?php

namespace App\Filament\Widgets;

use App\Models\MstFasemonitor;
use App\Models\MonitorTc;
use App\Models\Tc;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class MonitoringTeknisTable extends BaseWidget
{
    protected static ?string $heading = 'Monitoring Teknis';

    protected static bool $isDiscovered = false;

    protected int | string | array $columnSpan = 'full';

    public ?string $traceCode = null;

    protected $listeners = ['refreshMonitoringTeknis' => '$refresh'];

    protected function getTableQuery(): Builder
    {
        if (!$this->traceCode) {
            return MonitorTc::query()->whereRaw('1 = 0');
        }

        $tc = Tc::where('tracecode', $this->traceCode)->first();

        if (!$tc) {
            return MonitorTc::query()->whereRaw('1 = 0');
        }

        // Ambil ID monitor untuk grup Teknis
        $teknisMonitorIds = MstFasemonitor::where('grub_fasemonitor', 'Teknis')
            ->pluck('id_monitor');

        return MonitorTc::query()
            ->with(['fasemonitoring', 'kriteria', 'user'])
            ->where('id_tc', $tc->id_tc)
            ->whereIn('id_monitor', $teknisMonitorIds)
            ->orderBy('tgl_monitoring', 'desc');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('fasemonitoring.fase_monitoring')
                    ->label('Fase Monitoring')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fasemonitoring.parameter')
                    ->label('Parameter')
                    ->searchable()
                    ->wrap()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('kriteria.nm_kriteria')
                    ->label('Kriteria')
                    ->searchable()
                    ->wrap()
                    ->placeholder('Belum diisi')
                    ->default('-'),
                Tables\Columns\TextColumn::make('kriteria.nilai_kriteria')
                    ->label('Nilai Kriteria')
                    ->alignCenter()
                    ->badge()
                    ->color('success')
                    ->placeholder('-')
                    ->default('-'),
                Tables\Columns\TextColumn::make('nilai_monitor')
                    ->label('Nilai Monitor')
                    ->alignCenter()
                    ->badge()
                    ->color('primary')
                    ->placeholder('-')
                    ->default('-')
                    ->formatStateUsing(fn ($state) => $state ? number_format((float)$state, 2) : '-'),
                Tables\Columns\TextColumn::make('evalusi_monitoring')
                    ->label('Evaluasi')
                    ->wrap()
                    ->limit(50)
                    ->placeholder('-')
                    ->default('-'),
                Tables\Columns\TextColumn::make('tgl_monitoring')
                    ->label('Tanggal Monitoring')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('hasil')
                    ->label('Hasil Fase')
                    ->alignCenter()
                    ->badge()
                    ->color('warning')
                    ->placeholder('-')
                    ->default('-')
                    ->formatStateUsing(fn ($state) => $state ? number_format((float)$state, 2) : '-'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('fase_monitoring')
                    ->label('Fase Monitoring')
                    ->options(function () {
                        return MstFasemonitor::where('grub_fasemonitor', 'Teknis')
                            ->distinct()
                            ->pluck('fase_monitoring', 'fase_monitoring');
                    })
                    ->searchable(),
            ])
            ->defaultSort('tgl_monitoring', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('60s');
    }

    public function exportToExcel()
    {
        if (!$this->traceCode) {
            return null;
        }

        $tc = Tc::where('tracecode', $this->traceCode)->first();

        if (!$tc) {
            return null;
        }

        $teknisMonitorIds = MstFasemonitor::where('grub_fasemonitor', 'Teknis')
            ->pluck('id_monitor');

        $records = MonitorTc::where('id_tc', $tc->id_tc)
            ->whereIn('id_monitor', $teknisMonitorIds)
            ->with(['fasemonitoring', 'kriteria', 'user'])
            ->orderBy('tgl_monitoring', 'desc')
            ->get();

        $filename = 'monitoring-teknis-' . $this->traceCode . '-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Trace Code',
                'Fase Monitoring',
                'Parameter',
                'Kriteria',
                'Nilai Kriteria',
                'Nilai Monitor',
                'Evaluasi',
                'Hasil Fase',
                'Tanggal Monitoring',
                'User',
            ]);

            foreach ($records as $record) {
                fputcsv($file, [
                    $this->traceCode,
                    $record->fasemonitoring->fase_monitoring ?? '-',
                    $record->fasemonitoring->parameter ?? '-',
                    $record->kriteria->nm_kriteria ?? '-',
                    $record->kriteria->nilai_kriteria ?? '-',
                    $record->nilai_monitor ?? '-',
                    $record->evalusi_monitoring ?? '-',
                    $record->hasil ?? '-',
                    $record->tgl_monitoring ? \Carbon\Carbon::parse($record->tgl_monitoring)->format('d/m/Y') : '-',
                    $record->user->name ?? 'System',
                ]);
            }

            fclose($file);
        };

        return \Illuminate\Support\Facades\Response::stream($callback, 200, $headers);
    }

    public function exportToPdf()
    {
        // PDF export akan diimplementasikan sesuai desain yang dikirim
        \Filament\Notifications\Notification::make()
            ->title('Export PDF')
            ->body('Fitur export PDF dalam pengembangan. Desain akan disesuaikan dengan template yang diberikan.')
            ->info()
            ->send();
    }

    protected function getTableHeading(): ?string
    {
        return 'Monitoring Teknis - ' . ($this->traceCode ?? 'All');
    }

    protected function getTableDescription(): ?string
    {
        return 'Daftar data monitoring untuk aspek teknis yang telah diinput.';
    }
}
