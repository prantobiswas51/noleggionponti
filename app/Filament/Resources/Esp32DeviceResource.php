<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Esp32DeviceResource\Pages;
use App\Filament\Resources\Esp32DeviceResource\RelationManagers;
use App\Models\Esp32Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Esp32DeviceResource extends Resource
{
    protected static ?string $model = Esp32Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListEsp32Devices::route('/'),
            'create' => Pages\CreateEsp32Device::route('/create'),
            'edit' => Pages\EditEsp32Device::route('/{record}/edit'),
        ];
    }
}
