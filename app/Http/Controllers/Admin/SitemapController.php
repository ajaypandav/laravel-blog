<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;


class SitemapController extends Controller
{
    function sitemap() {
    	SitemapGenerator::create('https://rabinabaksheshop.com/')->getSitemap()->writeToDisk('public', 'sitemap.xml');
    }
}
