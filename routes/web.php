<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Admin Routes
Auth::routes();

Route::get('/', 'Front\IndexController@index');
Route::get('/about-us', 'Front\IndexController@aboutus');
Route::get('/contact-us', 'Front\IndexController@contactus');
Route::post('/contact', 'Front\IndexController@contactPost')->name('contact');
Route::get('/search', 'Front\BlogController@search');

Route::get('/category/{url}', 'Front\BlogController@category');
Route::get('/tag/{tag}', 'Front\BlogController@tag');
Route::get('/author/{author}', 'Front\BlogController@author');

Route::get('/{url}', 'Front\BlogController@blog')->name('blog');

// Blog comment route
Route::post('/blog/comment', 'Front\BlogController@comment')->name('blog.comment');

// Newsletter Route
Route::post('/newsletter', 'Front\IndexController@newsletter');

// Route::get('/home', 'HomeController@index')->name('home');

// Admin dataTable routes
Route::get('/admin/category/data', 'Admin\CategoryController@datatable');
Route::get('/admin/blog/data', 'Admin\BlogController@datatable');
Route::get('/admin/blogComment/{bid}/data', 'Admin\BlogController@commentData');
Route::get('/admin/subscriber/data', 'Admin\SubscriberController@datatable');
Route::get('/admin/contact/data', 'Admin\ContactController@datatable');
Route::get('/admin/notification', 'Admin\DashboardController@notification');

Route::group(['middleware' => ['auth']], function () {
    // Dashboard Route
    Route::get('/admin/dashboard', 'Admin\DashboardController@index');

    // Change Password Routes
    Route::get('/admin/change-password', 'Admin\SettingController@changePassword');
    Route::post('/admin/change-password', 'Admin\SettingController@updatePassword')->name('update.password');

    // Category Routes
    Route::resource('/admin/category', 'Admin\CategoryController');
    Route::get('/admin/category/{id}/destroy', 'Admin\CategoryController@destroy');
    Route::post('/admin/category/bulk', 'Admin\CategoryController@bulkAction')->name('category.bulk');

    // Blog Routes
    Route::resource('/admin/blog', 'Admin\BlogController');
    Route::get('/admin/blog/{id}/destroy', 'Admin\BlogController@destroy');
    Route::get('/admin/blog/{bid}/comment', 'Admin\BlogController@comment');
    Route::get('/admin/blogComment/{id}/destroy', 'Admin\BlogController@destroyComment');
    Route::post('/admin/blog/bulk', 'Admin\BlogController@bulkAction')->name('blog.bulk');
    Route::post('/admin/blogComment/bulk', 'Admin\BlogController@commentBulkAction')->name('blogComment.bulk');

    // Subscriber Routes
    Route::get('/admin/subscriber', 'Admin\SubscriberController@index');
    Route::get('/admin/subscriber/{id}/destroy', 'Admin\SubscriberController@destroy');
    Route::post('/admin/subscriber/bulk', 'Admin\SubscriberController@bulkAction')->name('subscriber.bulk');

    // Contacts Route
    Route::get('/admin/contact', 'Admin\ContactController@index');
    Route::get('/admin/contact/{id}/destroy', 'Admin\ContactController@destroy');
    Route::post('/admin/contact/bulk', 'Admin\ContactController@bulkAction')->name('contact.bulk');

    // System Configuration Route
    Route::get('/admin/config', 'Admin\ConfigController@index');
    Route::post('/admin/config', 'Admin\ConfigController@update')->name('update.config');

    // User profile routes
    Route::get('/admin/profile', 'Admin\SettingController@profile');
    Route::post('/admin/update', 'Admin\SettingController@profileUpdate')->name('profile.update');

    // Sitemap Route
    Route::get('/admin/sitemap', 'Admin\SitemapController@sitemap');
});
