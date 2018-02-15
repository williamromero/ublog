<?php

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

use Carbon\Carbon;

// Route::get('/', function () {
  // $today = Carbon::today();
  // $posts = App\Post::latest('published_at')->get();
  // return view('welcome')->with('posts', $posts);
  // return view('welcome', compact('posts', 'today'));
// });

Route::get('/', 'PagesController@home');

// Route::get('admin/posts', 'Admin\PostsController@index');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function (){
  Route::get('posts', 'PostsController@index')->name('admin.posts.index');
});

Route::get('posts', function() { return App\Post::all(); });
Route::get('admin', function() { return view('admin.dashboard'); })->middleware('auth');

Route::auth();

// Route::group(['prefix' => 'admin', 'namespace'])
