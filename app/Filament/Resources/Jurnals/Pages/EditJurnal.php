<?php

namespace App\Filament\Resources\Jurnals\Pages;

use App\Filament\Resources\Jurnals\JurnalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditJurnal extends EditRecord
{
    protected static string $resource = JurnalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
