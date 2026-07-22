<?php

namespace App\Filament\Resources\Conferences;

use App\Filament\Resources\Conferences\Pages\CreateConference;
use App\Filament\Resources\Conferences\Pages\EditConference;
use App\Filament\Resources\Conferences\Pages\ListConferences;
use App\Filament\Resources\Conferences\Pages\ViewConference;
use App\Models\Conference;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
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

class ConferenceResource extends Resource
{
    protected static ?string $model = Conference::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Conference')
                    ->required()
                    ->maxLength(255),

                DatePicker::make('event_date')
                    ->label('Tanggal Acara'),

                RichEditor::make('description')
                    ->label('Deskripsi'),

                FileUpload::make('poster')
                    ->label('Poster Conference')
                    ->image()
                    ->directory('conference-posters')
                    ->maxSize(10240)
                    ->saveUploadedFileUsing(function ($file) {
                        $filename = 'conference_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';
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
                            return $file->storePubliclyAs('conference-posters', $filename, 'public');
                        }

                        $destination = storage_path('app/public/conference-posters/' . $filename);
                        imagewebp($image, $destination, 75);
                        imagedestroy($image);

                        return 'conference-posters/' . $filename;
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

                TextColumn::make('event_date')
                    ->label('Tanggal Acara')
                    ->date()
                    ->sortable(),

                ImageColumn::make('poster')
                    ->label('Poster'),

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
            'index' => ListConferences::route('/'),
            'create' => CreateConference::route('/create'),
            'view' => ViewConference::route('/{record}'),
            'edit' => EditConference::route('/{record}/edit'),
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