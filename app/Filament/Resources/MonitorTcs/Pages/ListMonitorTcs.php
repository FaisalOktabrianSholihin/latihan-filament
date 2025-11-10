<?php

namespace App\Filament\Resources\MonitorTcs\Pages;

use App\Filament\Resources\MonitorTcs\MonitorTcResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMonitorTcs extends ListRecords
{
    protected static string $resource = MonitorTcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
