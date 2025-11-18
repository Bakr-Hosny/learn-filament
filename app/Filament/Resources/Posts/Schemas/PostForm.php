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
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
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
                    Select::make('category_id')
                        ->label('Category')
                        ->required()
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->native(false),
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

//                    Section::make('Users')->schema([
//
//                       Select::make('users')
//                           ->multiple()
//                           ->relationship('users' , 'name')
//                           ->searchable()
//                           ->preload()
//                           ->native(false),
//                    ]),


                ]),





            ])->columns(3);
    }
}
