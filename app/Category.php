<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title', 'cover_image', 'status', 'url_slug',
    ];

    protected $table = 'category';
}
