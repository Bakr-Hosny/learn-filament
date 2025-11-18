<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'color',
        'category_id',
        'content',
        'tags',
        'published',
    ];

    protected $casts = [
        'tags' => 'array',
        'published' => 'boolean',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class , 'post_users');
    }
}
