<?php

namespace App\Filament\Resources\Publishers;

use App\Filament\Resources\Publishers\Pages\CreatePublisher;
use App\Filament\Resources\Publishers\Pages\EditPublisher;
use App\Filament\Resources\Publishers\Pages\ListPublishers;
use App\Filament\Resources\Publishers\Pages\ViewPublisher;
use App\Models\Publisher;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PublisherResource extends Resource
{
    protected static ?string $model = Publisher::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Publisher')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('about')
                    ->label('Tentang Publisher'),

                FileUpload::make('logo_or_cover')
                    ->label('Logo / Cover Publisher')
                    ->image()
                    ->directory('publisher-images')
                    ->maxSize(10240)
                    ->saveUploadedFileUsing(function ($file) {
                        $filename = 'publisher_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';
                        $filePath = $file->getRealPath();
                        $info = getimagesize($filePath);
                        $mime = $info['mime'];

                        if ($mime == 'image/jpeg') {
                            $image = imagecreatefromjpeg($filePath);
                        } elseif ($mime == 'image/png') {
                            $image = imagecreatefrompng($filePath);
                        } elseif ($mime == 'image/webp') {
                            $image = imagecreatefromwebp($filePath);
                        } else {
                            return $file->storePubliclyAs('publisher-images', $filename, 'public');
                        }

                        $destination = storage_path('app/public/publisher-images/' . $filename);
                        imagewebp($image, $destination, 75);
                        imagedestroy($image);

                        return 'publisher-images/' . $filename;
                    }),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Publisher')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('logo_or_cover')
                    ->label('Logo'),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPublishers::route('/'),
            'create' => CreatePublisher::route('/create'),
            'view' => ViewPublisher::route('/{record}'),
            'edit' => EditPublisher::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}