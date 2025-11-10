<?php

namespace App\Filament\Resources\Tcs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TcsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_tc')
                    ->label('ID TC')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tracecode')
                    ->label('Trace Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('komoditi.nm_komoditi')
                    ->label('Komoditi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('budidaya.nm_asman_manager')
                    ->label('Penanggung Jawab')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tgl_tanam')
                    ->label('Tanggal Tanam')
                    ->date('d/m/Y')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('luas_tanam')
                    ->label('Luas (Ha)')
                    ->suffix(' Ha')
                    ->sortable(),
                TextColumn::make('tdk_tc')
                    ->label('TDK')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('wilayah_tc')
                    ->label('Wilayah')
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
