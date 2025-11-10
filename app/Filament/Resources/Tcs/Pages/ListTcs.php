<?php

namespace App\Filament\Resources\Tcs\Pages;

use App\Filament\Resources\Tcs\TcResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTcs extends ListRecords
{
    protected static string $resource = TcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
