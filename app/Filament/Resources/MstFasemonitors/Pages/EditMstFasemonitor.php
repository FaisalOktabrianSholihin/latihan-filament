<?php

namespace App\Filament\Resources\MstFasemonitors\Pages;

use App\Filament\Resources\MstFasemonitors\MstFasemonitorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMstFasemonitor extends EditRecord
{
    protected static string $resource = MstFasemonitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
