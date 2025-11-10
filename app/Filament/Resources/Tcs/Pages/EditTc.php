<?php

namespace App\Filament\Resources\Tcs\Pages;

use App\Filament\Resources\Tcs\TcResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTc extends EditRecord
{
    protected static string $resource = TcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
