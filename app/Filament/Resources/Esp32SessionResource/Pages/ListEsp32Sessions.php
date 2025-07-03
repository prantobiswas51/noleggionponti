<?php

namespace App\Filament\Resources\Esp32SessionResource\Pages;

use App\Filament\Resources\Esp32SessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEsp32Sessions extends ListRecords
{
    protected static string $resource = Esp32SessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
