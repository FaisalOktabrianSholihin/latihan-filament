<?php

namespace App\Filament\Resources\MstFasemonitors;

use App\Filament\Resources\MstFasemonitors\Pages\CreateMstFasemonitor;
use App\Filament\Resources\MstFasemonitors\Pages\EditMstFasemonitor;
use App\Filament\Resources\MstFasemonitors\Pages\ListMstFasemonitors;
use App\Filament\Resources\MstFasemonitors\Schemas\MstFasemonitorForm;
use App\Filament\Resources\MstFasemonitors\Tables\MstFasemonitorsTable;
use App\Models\MstFasemonitor;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstFasemonitorResource extends Resource
{
    protected static ?string $model = MstFasemonitor::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $recordTitleAttribute = 'fase_monitoring';

    protected static ?string $navigationLabel = 'Fase Monitor';

    protected static ?string $modelLabel = 'Fase Monitor';

    protected static ?string $pluralModelLabel = 'Data Fase Monitor';

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return MstFasemonitorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstFasemonitorsTable::configure($table);
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
            'index' => ListMstFasemonitors::route('/'),
            'create' => CreateMstFasemonitor::route('/create'),
            'edit' => EditMstFasemonitor::route('/{record}/edit'),
        ];
    }
}
