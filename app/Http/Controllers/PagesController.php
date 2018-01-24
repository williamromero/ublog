<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use Carbon\Carbon;

class PagesController extends Controller
{
  public function home() {
    $today = Carbon::today();
    $posts = Post::latest('published_at')->get();
    return view('welcome', compact('posts', 'today'));    
  }
}
