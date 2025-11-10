<?php

namespace App\Filament\Resources\MonitorTcs;

use App\Filament\Resources\MonitorTcs\Pages\CreateMonitorTc;
use App\Filament\Resources\MonitorTcs\Pages\EditMonitorTc;
use App\Filament\Resources\MonitorTcs\Pages\ListMonitorTcs;
use App\Filament\Resources\MonitorTcs\Schemas\MonitorTcForm;
use App\Filament\Resources\MonitorTcs\Tables\MonitorTcsTable;
use App\Models\MonitorTc;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MonitorTcResource extends Resource
{
    protected static ?string $model = MonitorTc::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $recordTitleAttribute = 'id_monitor_tc';

    protected static ?string $navigationLabel = 'Monitor TC';

    protected static ?string $modelLabel = 'Monitor TC';

    protected static ?string $pluralModelLabel = 'Data Monitor TC';

    protected static string|UnitEnum|null $navigationGroup = 'Data Transaksi';

    public static function form(Schema $schema): Schema
    {
        return MonitorTcForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MonitorTcsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMonitorTcs::route('/'),
            'create' => CreateMonitorTc::route('/create'),
            'edit' => EditMonitorTc::route('/{record}/edit'),
        ];
    }
}
