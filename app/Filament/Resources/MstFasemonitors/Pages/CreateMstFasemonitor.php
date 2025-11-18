<?php

namespace App\Filament\Resources\MstFasemonitors\Pages;

use App\Filament\Resources\MstFasemonitors\MstFasemonitorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMstFasemonitor extends CreateRecord
{
    protected static string $resource = MstFasemonitorResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }
}
