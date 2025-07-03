<?php

namespace App\Filament\Resources\Esp32SessionResource\Pages;

use App\Filament\Resources\Esp32SessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEsp32Session extends EditRecord
{
    protected static string $resource = Esp32SessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
