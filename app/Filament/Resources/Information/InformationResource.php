<?php

namespace App\Filament\Resources\Information;

use App\Filament\Resources\Information\Pages\CreateInformation;
use App\Filament\Resources\Information\Pages\EditInformation;
use App\Filament\Resources\Information\Pages\ListInformation;
use App\Models\Information;
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
use Illuminate\Support\Str;

class InformationResource extends Resource
{
    protected static ?string $model = Information::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Informasi')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('content')
                    ->label('Isi Berita / Informasi')
                    ->required(),

                FileUpload::make('image')
                    ->label('Gambar / Banner Informasi')
                    ->image()
                    ->directory('uploads/information')
                    ->maxSize(10240)
                    ->saveUploadedFileUsing(function ($file) {
                        $filename = 'info_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';
                        $filePath = $file->getRealPath();
                        $info = getimagesize($filePath);
                        $mime = $info['mime'];

                        // Pastikan folder penyimpanan tujuan sudah ada secara otomatis
                        $destinationPath = storage_path('app/public/uploads/information');
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }

                        if ($mime == 'image/jpeg') { 
                            $image = imagecreatefromjpeg($filePath); 
                        } elseif ($mime == 'image/png') { 
                            $image = imagecreatefrompng($filePath); 
                        } elseif ($mime == 'image/webp') { 
                            $image = imagecreatefromwebp($filePath); 
                        } else { 
                            return $file->storePubliclyAs('uploads/information', $filename, 'public'); 
                        }

                        $destination = $destinationPath . '/' . $filename;
                        imagewebp($image, $destination, 75);
                        imagedestroy($image);
                        
                        return 'uploads/information/' . $filename;
                    }),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([])
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
            'index' => ListInformation::route('/'),
            'create' => CreateInformation::route('/create'),
            'edit' => EditInformation::route('/{record}/edit'),
        ];
    }
}