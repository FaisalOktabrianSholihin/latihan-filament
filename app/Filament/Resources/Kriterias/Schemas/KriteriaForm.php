<?php

namespace App\Filament\Resources\Kriterias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\MstFasemonitor;

class KriteriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_monitor')
                    ->label('Parameter')
                    ->relationship('mstfasemonitoring', 'parameter')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('nm_kriteria')
                    ->label('Nama Kriteria')
                    ->required()
                    ->maxLength(255),
                TextInput::make('nilai_kriteria')
                    ->label('Nilai Kriteria')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100),
            ]);
    }
}
