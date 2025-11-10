<?php

namespace App\Filament\Resources\Budidayas\Pages;

use App\Filament\Resources\Budidayas\BudidayaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBudidaya extends EditRecord
{
    protected static string $resource = BudidayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
