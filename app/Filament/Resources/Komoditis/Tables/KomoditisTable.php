<?php

namespace App\Filament\Resources\Komoditis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KomoditisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_komoditi')
                    ->label('ID Komoditi')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nm_komoditi')
                    ->label('Nama Komoditi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ket_komoditi')
                    ->label('Keterangan')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
