<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Stránky';

    protected static ?string $modelLabel = 'Stránka';

    protected static ?string $pluralModelLabel = 'Stránky';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Label')
                    ->tabs([
                        Tab::make('Informace o stránce')
                            ->icon('heroicon-o-rectangle-group')
                            ->schema([
                                Tabs::make('Label')
                                    ->tabs([
                                        Tab::make('Hlavní informace')
                                            ->schema([
                                                Section::make('Základní informace o stránce')
                                                    ->description('Pojmenujte svou stránku.')
                                                    ->schema([
                                                        TextInput::make('name')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->label('Název stránky'),
                                                        TextInput::make('slug')
                                                            ->label('Slug · URL adresa (nepovinné, vytvoří se sama)'),
                                                    ])
                                                    ->columns(2),
                                            ]),
                                        Tab::make('Obsah')
                                            ->schema([
                                                Builder::make('content')
                                                    ->label('Obsah')
                                                    ->blocks([
                                                        Builder\Block::make('text')
                                                            ->label('Text')
                                                            ->schema([
                                                                RichEditor::make('source')
                                                                    ->label('')
                                                                    ->columnSpan(2)
                                                                    ->toolbarButtons([
                                                                        'bold',
                                                                        'bulletList',
                                                                        'codeBlock',
                                                                        'h2',
                                                                        'h3',
                                                                        'italic',
                                                                        'link',
                                                                        'orderedList',
                                                                        'redo',
                                                                        'strike',
                                                                        'underline',
                                                                        'undo',
                                                                    ])
                                                            ]),
                                                        Builder\Block::make('image')
                                                            ->schema([
                                                                TextInput::make('alt')
                                                                    ->label('Popis obrázku')
                                                                    ->required(),
                                                                Hidden::make('images_hash')
                                                                    ->default(substr(Str::uuid()->toString(), 0, 6))
                                                                    ->live()
                                                                    ->required(),
                                                                SpatieMediaLibraryFileUpload::make('images')
                                                                    ->live()
                                                                    ->collection(function (Get $get) {
                                                                        return $get('images_hash');
                                                                    })
                                                                    ->label('Obrázek')
                                                                    ->required()
                                                                    ->responsiveImages()
                                                                    ->preserveFilenames()
                                                                    ->downloadable()
                                                                    ->image()
                                                                    ->imageResizeMode('contain')
                                                                    ->imageResizeTargetWidth('1920')
                                                                    ->imageResizeUpscale(false)
                                                                    ->reorderable()
                                                                    ->appendFiles()
                                                                    ->openable()
                                                                    ->removeUploadedFileButtonPosition('right')
                                                            ]),
                                                    ])
                                            ]),
                                    ])
                                    ->columnSpan(2)
                            ]),
                    ])
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Název stránky'),
                TextInputColumn::make('order')
                    ->label('Pořadí')
                    ->rules(['required', 'max:100']),
                Tables\Columns\ToggleColumn::make('visible')
                    ->label('Zobrazit na webu')
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
