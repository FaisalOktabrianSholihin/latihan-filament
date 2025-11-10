<?php

namespace App\Filament\Resources\MstFasemonitors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstFasemonitorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_monitor')
                    ->label('ID Monitor')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('grub_fasemonitor')
                    ->label('Grup Fase Monitor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fase_monitoring')
                    ->label('Fase Monitoring')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parameter')
                    ->label('Parameter')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('titik_kritis')
                    ->label('Titik Kritis')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('monitoring_poin')
                    ->label('Monitoring Poin')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
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
