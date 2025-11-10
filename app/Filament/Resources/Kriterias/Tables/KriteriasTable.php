<?php

namespace App\Filament\Resources\Kriterias\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KriteriasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_kriteria')
                    ->label('ID Kriteria')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mstfasemonitoring.fase_monitoring')
                    ->label('Fase Monitoring')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nm_kriteria')
                    ->label('Nama Kriteria')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nilai_kriteria')
                    ->label('Nilai Kriteria')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
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
