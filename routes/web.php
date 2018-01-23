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

Route::get('/', function () {
  $today = Carbon::today();
  $posts = App\Post::latest('published_at')->get();
  // return view('welcome')->with('posts', $posts);
  return view('welcome', compact('posts', 'today'));
});

Route::get('posts', function(){
  return App\Post::all();
});

Route::get('home', function() {
  return view('admin.dashboard');
})->middleware('auth');

Route::auth();
