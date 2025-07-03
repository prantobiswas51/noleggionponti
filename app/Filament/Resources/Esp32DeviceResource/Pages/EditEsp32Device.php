<?php

namespace App\Filament\Resources\Esp32DeviceResource\Pages;

use App\Filament\Resources\Esp32DeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEsp32Device extends EditRecord
{
    protected static string $resource = Esp32DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
