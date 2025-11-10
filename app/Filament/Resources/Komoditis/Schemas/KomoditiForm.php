<?php

namespace App\Filament\Resources\Komoditis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class KomoditiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_komoditi')
                    ->label('ID Komoditi')
                    ->required()
                    ->numeric()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                TextInput::make('nm_komoditi')
                    ->label('Nama Komoditi')
                    ->required()
                    ->maxLength(255),
                Textarea::make('ket_komoditi')
                    ->label('Keterangan')
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }
}
