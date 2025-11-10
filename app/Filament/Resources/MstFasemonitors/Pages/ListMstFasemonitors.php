<?php

namespace App\Filament\Resources\MstFasemonitors\Pages;

use App\Filament\Resources\MstFasemonitors\MstFasemonitorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstFasemonitors extends ListRecords
{
    protected static string $resource = MstFasemonitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
