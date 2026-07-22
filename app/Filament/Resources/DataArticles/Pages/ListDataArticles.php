<?php

namespace App\Filament\Resources\DataArticles\Pages;

use App\Filament\Resources\DataArticles\DataArticleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDataArticles extends ListRecords
{
    protected static string $resource = DataArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
