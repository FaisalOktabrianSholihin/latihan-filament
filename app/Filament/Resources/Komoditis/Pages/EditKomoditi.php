<?php

namespace App\Filament\Resources\Komoditis\Pages;

use App\Filament\Resources\Komoditis\KomoditiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKomoditi extends EditRecord
{
    protected static string $resource = KomoditiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
