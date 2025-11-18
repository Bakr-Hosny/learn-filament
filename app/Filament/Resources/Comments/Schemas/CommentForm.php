<?php

namespace App\Filament\Resources\Comments\Schemas;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user' , 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('content'),
                MorphToSelect::make('commentable')
                    ->label('Comment Type')
                    ->types([
                        MorphToSelect\Type::make(Post::class)->titleAttribute('title'),
                        MorphToSelect\Type::make(User::class)->titleAttribute('name'),
                        MorphToSelect\Type::make(Comment::class)->titleAttribute('id'),
                    ])
                    ->searchable()
                    ->preload(),
            ]);
    }
}
