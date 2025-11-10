<?php

namespace App\Filament\Resources\Budidayas;

use App\Filament\Resources\Budidayas\Pages\CreateBudidaya;
use App\Filament\Resources\Budidayas\Pages\EditBudidaya;
use App\Filament\Resources\Budidayas\Pages\ListBudidayas;
use App\Filament\Resources\Budidayas\Schemas\BudidayaForm;
use App\Filament\Resources\Budidayas\Tables\BudidayasTable;
use App\Models\Budidaya;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BudidayaResource extends Resource
{
    protected static ?string $model = Budidaya::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'nm_asman_manager';

    protected static ?string $navigationLabel = 'Budidaya';

    protected static ?string $modelLabel = 'Budidaya';

    protected static ?string $pluralModelLabel = 'Data Budidaya';

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return BudidayaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BudidayasTable::configure($table);
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
            'index' => ListBudidayas::route('/'),
            'create' => CreateBudidaya::route('/create'),
            'edit' => EditBudidaya::route('/{record}/edit'),
        ];
    }
}
