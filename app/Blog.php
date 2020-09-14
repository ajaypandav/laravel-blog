<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'uid', 'title', 'description', 'header_image', 'image', 'status', 'hot_post', 'url_slug', 'view_count', 'meta_title', 'meta_desc', 'meta_keyword'
    ];

    protected $table = 'blog';
}
