<?php

namespace App\Filament\Resources\Budidayas\Pages;

use App\Filament\Resources\Budidayas\BudidayaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBudidayas extends ListRecords
{
    protected static string $resource = BudidayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
