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

Route::get('/', function () {
  $posts = App\Post::latest('published_at')->get();
  // return view('welcome')->with('posts', $posts);
  return view('welcome', compact('posts'));
});

Route::get('posts', function(){
  return App\Post::all();
});

Route::get('home', function() {
  return view('admin.dashboard');
});

Route::auth();
