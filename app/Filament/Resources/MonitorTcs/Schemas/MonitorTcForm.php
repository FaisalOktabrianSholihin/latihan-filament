<?php

namespace App\Filament\Resources\MonitorTcs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MonitorTcForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_tc')
                    ->label('Trace Code')
                    ->relationship('tc', 'tracecode')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('id_monitor')
                    ->label('Fase Monitoring')
                    ->relationship('fasemonitoring', 'fase_monitoring')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('id_kriteria')
                    ->label('Kriteria')
                    ->relationship('kriteria', 'nm_kriteria')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('nilai_monitor')
                    ->label('Nilai Monitor')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100),
                Textarea::make('ket_monitor')
                    ->label('Keterangan Monitor')
                    ->required()
                    ->rows(3)
                    ->maxLength(500),
                DatePicker::make('tgl_monitoring')
                    ->label('Tanggal Monitoring')
                    ->required()
                    ->native(false),
                DatePicker::make('tgl_update')
                    ->label('Tanggal Update')
                    ->required()
                    ->native(false),
                Textarea::make('evalusi_monitoring')
                    ->label('Evaluasi Monitoring')
                    ->required()
                    ->rows(3)
                    ->maxLength(500),
                Select::make('hasil')
                    ->label('Hasil')
                    ->options([
                        'Sesuai' => 'Sesuai',
                        'Tidak Sesuai' => 'Tidak Sesuai',
                        'Perlu Perbaikan' => 'Perlu Perbaikan',
                    ])
                    ->required(),
            ]);
    }
}
