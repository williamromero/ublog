<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  // This is the way to handle "published_at" with Carbon Package
  protected $dates = ['published_at'];

  public function category($value='') { 
    return $this-> belongsTo(Category::class);
  }

  public function tags() { 
    return $this-> belongsToMany(Tag::class);
  } 
  
}
