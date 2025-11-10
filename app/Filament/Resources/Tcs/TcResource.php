<?php

namespace App\Filament\Resources\Tcs;

use App\Filament\Resources\Tcs\Pages\CreateTc;
use App\Filament\Resources\Tcs\Pages\EditTc;
use App\Filament\Resources\Tcs\Pages\ListTcs;
use App\Filament\Resources\Tcs\Schemas\TcForm;
use App\Filament\Resources\Tcs\Tables\TcsTable;
use App\Models\Tc;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TcResource extends Resource
{
    protected static ?string $model = Tc::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $recordTitleAttribute = 'tracecode';

    protected static ?string $navigationLabel = 'Trace Code';

    protected static ?string $modelLabel = 'Trace Code';

    protected static ?string $pluralModelLabel = 'Data Trace Code';

    protected static string|UnitEnum|null $navigationGroup = 'Data Transaksi';

    public static function form(Schema $schema): Schema
    {
        return TcForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TcsTable::configure($table);
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
            'index' => ListTcs::route('/'),
            'create' => CreateTc::route('/create'),
            'edit' => EditTc::route('/{record}/edit'),
        ];
    }
}
