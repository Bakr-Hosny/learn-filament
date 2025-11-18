<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Post Details')->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255),

                    ColorPicker::make('color')
                        ->required(),

                    MarkdownEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpan(2)->columns(2),

                Group::make([
                    Section::make('Images')->schema([
                        FileUpload::make('thumbnail')
                            ->disk('public')
                            ->directory('thumbnails')
                            ->image()
                            ->helperText('Upload thumbnail image'),
                    ]),


                    Section::make('Meta')->schema([

                        TagsInput::make('tags')
                            ->required(),

                        Checkbox::make('published')
                            ->required(),
                    ]),


                ]),





            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('id')
                    ->label('Id')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                ColorColumn::make('color')
                    ->label('Color')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->toggleable()
                    ->getStateUsing(fn ($record) =>
                    $record->thumbnail ? asset('storage/' . $record->thumbnail) : null
                    ),
                TextColumn::make('tags')
                    ->label('Tags')
                    ->toggleable(),
                CheckboxColumn::make('published')
                    ->label('Published')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Published On')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
              //  AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
