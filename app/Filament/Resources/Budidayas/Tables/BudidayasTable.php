<?php

namespace App\Filament\Resources\Budidayas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BudidayasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_budidaya')
                    ->label('ID Budidaya')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('id_asman_manager')
                    ->label('ID Asman/Manager')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nm_asman_manager')
                    ->label('Nama Asman/Manager')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('namaAtasan')
                    ->label('Nama Atasan')
                    ->searchable()
                    ->sortable(),
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
