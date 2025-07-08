<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Esp32Device;
use App\Models\Esp32Session;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Esp32SessionResource\Pages;
use App\Filament\Resources\Esp32SessionResource\RelationManagers;

class Esp32SessionResource extends Resource
{
    protected static ?string $model = Esp32Session::class;

    protected static ?string $navigationIcon = 'heroicon-s-clock';
    protected static ?string $navigationLabel = 'Sessions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id'),
                TextInput::make('esp32_device_id.name'),
                TextInput::make('started_at'),
                TextInput::make('expires_at'),
                TextInput::make('last_deducted_at'),
                TextInput::make('active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('user_id')->getStateUsing(function ($record) {
                    return User::where('id', $record->user_id)->pluck('name')->first() ?? 'No Name';
                })->label('User'),
                TextColumn::make('esp32_device_id')->getStateUsing(function ($record) {
                    return Esp32Device::where('id', $record->esp32_device_id)->pluck('identifier')->first() ?? 'No Device';
                }),
                TextColumn::make('started_at'),
                TextColumn::make('expires_at'),
                TextColumn::make('last_deducted_at'),
                TextColumn::make('active'),
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
