<?php

namespace App\Filament\Resources\MonitorTcs\Pages;

use App\Filament\Resources\MonitorTcs\MonitorTcResource;
use App\Models\MonitorTc;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Response;

class ListMonitorTcs extends ListRecords
{
    protected static string $resource = MonitorTcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export to Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(fn() => $this->exportToExcel()),
            CreateAction::make(),
        ];
    }

    public function exportToExcel()
    {
        // Get filtered data
        $query = $this->getFilteredTableQuery();
        $records = $query->with(['tc', 'kriteria.mstfasemonitoring', 'user'])->get();

        // Prepare CSV data
        $filename = 'monitoring-data-' . now()->format('Y-m-d-His') . '.csv';

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
                'ID',
                'Trace Code',
                'Tanggal Monitoring',
                'Fase Monitoring',
                'Parameter',
                'Kriteria',
                'Nilai Kriteria',
                'Nilai Monitor',
                'Evaluasi',
                'User',
                'Hasil',
                'Keterangan',
                'Tanggal Update',
            ]);

            // Add data
            foreach ($records as $record) {
                fputcsv($file, [
                    $record->id_monitor_tc,
                    $record->tc->tracecode ?? '-',
                    $record->tgl_monitoring ? \Carbon\Carbon::parse($record->tgl_monitoring)->format('d/m/Y') : '-',
                    $record->kriteria->mstfasemonitoring->fase_monitoring ?? '-',
                    $record->kriteria->mstfasemonitoring->parameter ?? '-',
                    $record->kriteria->nm_kriteria ?? '-',
                    $record->kriteria->nilai_kriteria ?? '-',
                    $record->nilai_monitor,
                    $record->evalusi_monitoring ?? '-',
                    $record->user->name ?? '-',
                    $record->hasil ?? '-',
                    $record->ket_monitor ?? '-',
                    $record->tgl_update ? \Carbon\Carbon::parse($record->tgl_update)->format('d/m/Y H:i') : '-',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
