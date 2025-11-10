<?php

namespace App\Filament\Resources\MonitorTcs\Pages;

use App\Filament\Resources\MonitorTcs\MonitorTcResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMonitorTc extends EditRecord
{
    protected static string $resource = MonitorTcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
