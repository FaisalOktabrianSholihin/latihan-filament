<?php

namespace App\Filament\Resources\MstFasemonitors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MstFasemonitorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('grub_fasemonitor')
                    ->label('Grup Fase Monitor')
                    ->required()
                    ->maxLength(100),
                TextInput::make('fase_monitoring')
                    ->label('Fase Monitoring')
                    ->required()
                    ->maxLength(255),
                TextInput::make('parameter')
                    ->label('Parameter')
                    ->required()
                    ->maxLength(255),
                TextInput::make('titik_kritis')
                    ->label('Titik Kritis')
                    ->required()
                    ->maxLength(255),
                Textarea::make('monitoring_poin')
                    ->label('Monitoring Poin')
                    ->required()
                    ->rows(3),
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(3),
            ]);
    }
}
