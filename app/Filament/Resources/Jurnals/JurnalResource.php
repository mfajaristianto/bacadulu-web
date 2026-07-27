<?php

namespace App\Filament\Resources\Jurnals;

use App\Filament\Resources\Jurnals\Pages\CreateJurnal;
use App\Filament\Resources\Jurnals\Pages\EditJurnal;
use App\Filament\Resources\Jurnals\Pages\ListJurnals;
use App\Models\Jurnal;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JurnalResource extends Resource
{
    protected static ?string $model = Jurnal::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('deskripsi'),

                // 1. File Upload untuk Dokumen PDF Jurnal
                FileUpload::make('file_pdf')
                    ->label('File Jurnal (PDF)')
                    ->disk('public')
                    ->directory('jurnal-pdf')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required(),

                // 2. File Upload Cover Gambar
                FileUpload::make('gambar')
                    ->label('Cover / Gambar Jurnal')
                    ->image()
                    ->disk('public')
                    ->directory('jurnal-images')
                    ->visibility('public')
                    ->maxSize(10240)
                    ->panelLayout('compact'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJurnals::route('/'),
            'create' => CreateJurnal::route('/create'),
            'edit' => EditJurnal::route('/{record}/edit'),
        ];
    }
}