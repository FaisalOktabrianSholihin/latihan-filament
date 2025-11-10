<?php

namespace App\Filament\Resources\Budidayas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class BudidayaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_budidaya')
                    ->label('ID Budidaya')
                    ->required()
                    ->numeric()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                TextInput::make('id_asman_manager')
                    ->label('ID Asman/Manager')
                    ->required()
                    ->maxLength(10),
                TextInput::make('nm_asman_manager')
                    ->label('Nama Asman/Manager')
                    ->required()
                    ->maxLength(255),
                Select::make('id_atasan')
                    ->label('Atasan')
                    ->options([
                        '013' => 'Dodi W',
                        '012' => 'Sutikno A',
                        '008' => 'M. Nurhadi',
                        '009' => 'Wido S',
                        '391' => 'Nanang Priwahyudi',
                        '307' => 'Abdul Hamid',
                        '023' => 'Dedy Wahyudi',
                    ])
                    ->searchable()
                    ->nullable(),
            ]);
    }
}
