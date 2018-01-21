<?php

use App\Post;
use App\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      Category::truncate();
      Post::truncate();

      $category = new Category;
      $category->name = 'Laravel';
      $category->save();

      $category = new Category;
      $category->name = 'Ruby on Rails';
      $category->save();

      $post = new Post;
      $post->title = "Nunc dignissim risus id metus.";
      $post->excerpt = "Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.";
      $post->body = "Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor.";
      $post->published_at = Carbon::now()->subDays(365);
      $post->category_id = 2;
      $post->save();

      $post = new Post;
      $post->title = "Vestibulum auctor dapibus neque.";
      $post->excerpt = "Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.";
      $post->body = "Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor.";
      $post->published_at = Carbon::now()->subDays(200);
      $post->category_id = 1;
      $post->save();

      $post = new Post;
      $post->title = "Vivamus molestie gravida turpis.";
      $post->excerpt = "Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.";
      $post->body = "Suspendisse mauris. Fusce accumsan mollis eros. Pellentesque a diam sit amet mi ullamcorper vehicula. Integer adipiscing risus a sem. Nullam quis massa sit amet nibh viverra malesuada.";
      $post->published_at = Carbon::now()->subDays(20);
      $post->category_id = 2;
      $post->save();

      $post = new Post;
      $post->title = "Nunc dignissim risus id metus.";
      $post->excerpt = "Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.";
      $post->body = "Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor.";
      $post->published_at = Carbon::now()->subDays(1);
      $post->category_id = 1;
      $post->save();

    }
}
