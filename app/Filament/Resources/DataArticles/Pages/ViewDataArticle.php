<?php

namespace App\Filament\Resources\DataArticles\Pages;

use App\Filament\Resources\DataArticles\DataArticleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDataArticle extends ViewRecord
{
    protected static string $resource = DataArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
