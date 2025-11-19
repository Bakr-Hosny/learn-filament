<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
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
//                Filter::make('Published')->query(
//                    function ($query){
//                        $query->where('published' , true);
//                    }
//                ),
//                Filter::make('unPublished')->query(
//                    function ($query){
//                        $query->where('published' , false);
//                    }
//                )

                TernaryFilter::make('published'),
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category' , 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
