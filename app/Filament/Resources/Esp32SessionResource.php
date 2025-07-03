<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Esp32SessionResource\Pages;
use App\Filament\Resources\Esp32SessionResource\RelationManagers;
use App\Models\Esp32Session;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Esp32SessionResource extends Resource
{
    protected static ?string $model = Esp32Session::class;

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
                //
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
            'index' => Pages\ListEsp32Sessions::route('/'),
            'create' => Pages\CreateEsp32Session::route('/create'),
            'edit' => Pages\EditEsp32Session::route('/{record}/edit'),
        ];
    }
}
