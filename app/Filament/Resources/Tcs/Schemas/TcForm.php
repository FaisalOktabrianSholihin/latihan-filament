<?php

namespace App\Filament\Resources\Tcs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class TcForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_tc')
                    ->label('ID TC')
                    ->required()
                    ->numeric()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                TextInput::make('tracecode')
                    ->label('Trace Code')
                    ->required()
                    ->maxLength(50),
                Select::make('id_komoditi')
                    ->label('Komoditi')
                    ->relationship('komoditi', 'nm_komoditi')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('id_budidaya')
                    ->label('Penanggung Jawab')
                    ->relationship('budidaya', 'nm_asman_manager')
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('tgl_tanam')
                    ->label('Tanggal Tanam')
                    ->required()
                    ->native(false),
                TextInput::make('luas_tanam')
                    ->label('Luas Tanaman (Ha)')
                    ->required()
                    ->maxLength(50)
                    ->suffix('Ha'),
                TextInput::make('tdk_tc')
                    ->label('TDK TC')
                    ->required()
                    ->maxLength(50),
                TextInput::make('wilayah_tc')
                    ->label('Wilayah TC')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
