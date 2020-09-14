<?php

namespace App\Traits;

use DB;
use Illuminate\Support\Facades\View;

trait CommonTrait
{
    public function __construct()
    {
        $categories = DB::table('category')->where('status', 1)->orderBy('title', 'asc')->get();
        $tags       = DB::table('blog_tag')->groupBy('tag')->limit(15)->get();

        foreach ($categories as $key => $value) {
        	$catCount = DB::table('blog_category')->where('cid', $value->id)->count();
        	$categories[$key]->count = $catCount;

            $blogs = DB::table('blog_category')
                ->select('blog.title', 'blog.url_slug', 'blog.image', 'blog.created_at', 'users.name as author')
                ->leftJoin('blog', 'blog.id', '=', 'blog_category.bid')
                ->leftJoin('users', 'users.id', '=', 'blog.uid')
                ->where('blog.status', 1)
                ->where('blog_category.cid', $value->id)
                ->limit(3)
                ->get();

            $categories[$key]->blogs = $blogs;
        }

        // Get Popular posts
        $popularPost = DB::table('blog')
            ->select('blog.id', 'blog.title', 'blog.url_slug', 'blog.image', 'users.name as author')
            ->leftJoin('users', 'users.id', '=', 'blog.uid')
            ->where('blog.status', 1)
            ->orderBy('blog.view_count', 'desc')
            ->limit(5)
            ->get();

        foreach ($popularPost as $key => $value) {
            $blogCat = DB::table('blog_category')
                ->select('category.title', 'category.url_slug')
                ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
                ->where('blog_category.bid', $value->id)
                ->get();

            $popularPost[$key]->category = $blogCat;
        }

        // Get system configuration data
        $config     = array();
        $configData = DB::table('config')->get();

        foreach ($configData as $key => $value) {
            $config[$value->option_key] = $value->option_value;
        }

        $config = (object) $config;

        View::share(['categories' => $categories, 'tags' => $tags, 'popular_post' => $popularPost, 'config' => $config]);
    }
}
