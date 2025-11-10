<?php

namespace App\Filament\Resources\Komoditis\Pages;

use App\Filament\Resources\Komoditis\KomoditiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKomoditis extends ListRecords
{
    protected static string $resource = KomoditiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
