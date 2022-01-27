<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/about', function () {
//     return view('about');
// });

ROUTE::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
ROUTE::get('/secret', 'HomeController@secret')
    ->name('secret')
    ->middleware('can:secret.page');
Route::get('/posts/{id}/tag', 'PostTagController@index')->name('poststag.index');
Route::get('/posts/archive', 'PostController@archive')->name('archive');
Route::get('/posts/all', 'PostController@allPosts')->name('all');
Route::resource('posts', 'PostController');
Route::resource('post.comments', 'PostCommentController')->only(['store', 'show']);
Route::resource('users', 'userController')->only(['show', 'edit', 'update']);

Auth::routes();

Route::patch('posts/restore/{id}', 'PostController@restorePost')->name('restore');
Route::delete('posts/forceDelete/{id}', 'PostController@forceDelete')->name('forceDelete');
ROUTE::get('/about', 'HomeController@about')->name('about');
ROUTE::get('/home', 'HomeController@index')->name('home');
