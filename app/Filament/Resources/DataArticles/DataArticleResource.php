<?php

namespace App\Filament\Resources\DataArticles;

use App\Filament\Resources\DataArticles\Pages\CreateDataArticle;
use App\Filament\Resources\DataArticles\Pages\EditDataArticle;
use App\Filament\Resources\DataArticles\Pages\ListDataArticles;
use App\Filament\Resources\DataArticles\Pages\ViewDataArticle;
use App\Models\DataArticle;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class DataArticleResource extends Resource
{
    protected static ?string $model = DataArticle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Artikel')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('description')
                    ->label('Deskripsi / Konten'),

                FileUpload::make('image')
                    ->label('Gambar Artikel')
                    ->image()
                    ->directory('article-images')
                    ->maxSize(10240)
                    ->saveUploadedFileUsing(function ($file) {
                        $filename = 'article_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';
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
                            return $file->storePubliclyAs('article-images', $filename, 'public');
                        }

                        $destination = storage_path('app/public/article-images/' . $filename);
                        imagewebp($image, $destination, 75);
                        imagedestroy($image);

                        return 'article-images/' . $filename;
                    }),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('image')
                    ->label('Gambar'),

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
            'index' => ListDataArticles::route('/'),
            'create' => CreateDataArticle::route('/create'),
            'view' => ViewDataArticle::route('/{record}'),
            'edit' => EditDataArticle::route('/{record}/edit'),
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