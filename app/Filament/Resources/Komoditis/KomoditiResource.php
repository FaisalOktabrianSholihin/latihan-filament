<?php

namespace App\Filament\Resources\Komoditis;

use App\Filament\Resources\Komoditis\Pages\CreateKomoditi;
use App\Filament\Resources\Komoditis\Pages\EditKomoditi;
use App\Filament\Resources\Komoditis\Pages\ListKomoditis;
use App\Filament\Resources\Komoditis\Schemas\KomoditiForm;
use App\Filament\Resources\Komoditis\Tables\KomoditisTable;
use App\Models\Komoditi;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KomoditiResource extends Resource
{
    protected static ?string $model = Komoditi::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $recordTitleAttribute = 'nm_komoditi';

    protected static ?string $navigationLabel = 'Komoditi';

    protected static ?string $modelLabel = 'Komoditi';

    protected static ?string $pluralModelLabel = 'Data Komoditi';

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return KomoditiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KomoditisTable::configure($table);
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
            'index' => ListKomoditis::route('/'),
            'create' => CreateKomoditi::route('/create'),
            'edit' => EditKomoditi::route('/{record}/edit'),
        ];
    }
}
