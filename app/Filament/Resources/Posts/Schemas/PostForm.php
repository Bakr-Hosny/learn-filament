<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make('Create New Post')
                    ->tabs([
                        Tab::make('Post Info')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),

                                Select::make('category_id')
                                    ->label('Category')
                                    ->required()
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false),

                                ColorPicker::make('color')->required(),
                        ])->columns(2),

                        Tab::make('Content')
                            ->icon('heroicon-o-pencil-square')
                            ->schema([
                                MarkdownEditor::make('content')
                                    ->required()
                                    ->columnSpanFull(),
                        ]),

                        Tab::make('Settings')
                            ->icon('heroicon-o-cog')
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->disk('public')
                                    ->directory('thumbnails')
                                    ->image()
                                    ->helperText('Upload thumbnail image'),
                        ]),

                        Tab::make('Meta')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                TagsInput::make('tags')->required(),
                                Checkbox::make('published')->required()->columnSpanFull(),
                        ])->columns(2),
                    ]),

            ])
            ->columns(1);
    }
}
