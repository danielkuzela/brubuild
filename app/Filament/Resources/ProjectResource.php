<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Projekty';

    protected static ?string $modelLabel = 'Projekt';

    protected static ?string $pluralModelLabel = 'Projekty';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Label')
                    ->tabs([
                        Tab::make('Informace o projektu')
                            ->icon('heroicon-o-rectangle-group')
                            ->schema([
                                Section::make('Základní informace o projektu')
                                    ->description('Zadejte název projektu případně krátký popis.')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Název projektu'),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Popis projektu')
                                            ->rows(5),
                                    ]),
                            ]),
                        Tab::make('Galerie')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Galerie')
                                    ->description('Fotky v galerii projektu. Můžete nahrát několik fotek najednou.')
                                    ->schema([
                                        Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                                            ->collection('gallery')
                                            ->label('')
                                            ->responsiveImages()
                                            ->preserveFilenames()
                                            ->multiple()
                                            ->downloadable()
                                            ->image()
                                            ->imageResizeMode('contain')
                                            ->imageResizeTargetWidth('2880')
                                            ->imageResizeUpscale(false)
                                            ->reorderable()
                                            ->appendFiles()
                                            ->openable()
                                            ->removeUploadedFileButtonPosition('right')
                                    ]),
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
                    ->label('Název projektu'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
