<?php

namespace App\Filament\Resources\Jurnals\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JurnalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
    TextInput::make('judul')
        ->required(),

    Textarea::make('deskripsi')
        ->columnSpanFull(),

    FileUpload::make('gambar')
        ->image()
        ->directory('jurnals')
        ->disk('public'),

    FileUpload::make('file_pdf')
        ->acceptedFileTypes(['application/pdf'])
        ->directory('jurnals/pdf')
        ->disk('public'),
            ]);
    }
}
