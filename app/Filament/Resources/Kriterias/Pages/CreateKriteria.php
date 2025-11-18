<?php

namespace App\Filament\Resources\Kriterias\Pages;

use App\Filament\Resources\Kriterias\KriteriaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKriteria extends CreateRecord
{
    protected static string $resource = KriteriaResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }
}
