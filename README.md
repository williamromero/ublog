#### Find PID number:

<pre>
  ps -ef | grep mysql
</pre>

#### Create migrations:

<pre>
  php artisan make:model Post -m
  php artisan make:model Category -m
</pre>

To run migrations:

<pre>
  php artisan migrate
</pre>


#### Create relations - Belongs To

In Post model, add the relation **belongs to**

<pre>
  public function category($value='') { 
    return $this-> belongsTo(Category::class);
  }
</pre>

And later, create the field which will recognize the ID from Category which will
be stored on Post table. So, to add this column, go to the Post migration and insert
the next field:

<pre>
  public function up()
  {
      Schema::create('posts', function (Blueprint $table) {
          $table->increments('id');
          $table->string('title');
          $table->mediumText('excerpt');
          $table->text('body');
          $table->timestamp('published_at')->nullable();
          <b>$table->unsignedInteger('category_id');</b>
          $table->timestamps();
      });
  }
</pre>

And after that, run the migration. If you want to return one migration below
use the command:

<pre>
  php artisan migrate:rollback
</pre>

If you want to redefine every table you had created to don't run the command many times
you can use:

<pre>
  php artisan migrate:refresh
    Rolling back: 2018_01_12_023806_create_categories_table
    Rolling back: 2018_01_09_033003_create_posts_table
    Rolling back: 2014_10_12_100000_create_password_resets_table
    Rolling back: 2014_10_12_000000_create_users_table
  <b>
    Migrated: 2014_10_12_000000_create_users_table
    Migrated: 2014_10_12_100000_create_password_resets_table
    Migrated: 2018_01_09_033003_create_posts_table
    Migrated: 2018_01_12_023806_create_categories_table
  </b>
</pre>

#### Create seeders:

Create a PostTable Seeder with the next command:

<pre>
  php artisan make:seeder PostTableSeeder
</pre>

Now, inside on **/Database/seeds/DatabaseSeeder.php** file, allow to the main seeder command the
**PostTableSeeder.php** file.

<pre>
  public function run () {
    $this->call(PostsTableSeeder::class);
  }
</pre> 

Now, inside of **PostTableSeeder.php** file we need to create the seeder information to load the dummy records which will be stored on the table.

Import the models:

<pre>
  &lt;?php
  <b>
  use App\Post;
  use App\Category;
  use Carbon\Carbon;
  </b>
</pre>

Create de categories dummy data:

<pre>
  use Illuminate\Database\Seeder;
  class PostTableSeeder extends Seeder {
    public function run() {
      &nbsp;
      Category::truncate();  // This line remove the last information stored
      Post::truncate();  // This line remove the last information stored
      &nbsp;
      $category = new Category;
      $category-&gt;name = 'Laravel';
      $category-&gt;save();
      &nbsp;
      $category = new Category;
      $category-&gt;name = 'Ruby on Rails';
      $category-&gt;save();
</pre>

<pre>
      &nbsp;
      $post = new Post;
      $post-&gt;title = "Nunc dignissim risus id metus.";
      $post-&gt;excerpt = "Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.";
      $post-&gt;body = "Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor.";
      $post-&gt;published_at = Carbon::now()->subDays(2);
      $post-&gt;category_id = 2;
      $post-&gt;save();
      &nbsp;
      $post = new Post;
      $post-&gt;title = "Vestibulum auctor dapibus neque.";
      $post-&gt;excerpt = "Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.";
      $post-&gt;body = "Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor.";
      $post-&gt;published_at = Carbon::now()->subDays(100);
      $post-&gt;category_id = 1;
      $post-&gt;save();
      &nbsp;
      $post = new Post;
      $post-&gt;title = "Vivamus molestie gravida turpis.";
      $post-&gt;excerpt = "Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.";
      $post-&gt;body = "Suspendisse mauris. Fusce accumsan mollis eros. Pellentesque a diam sit amet mi ullamcorper vehicula. Integer adipiscing risus a sem. Nullam quis massa sit amet nibh viverra malesuada.";
      $post-&gt;published_at = Carbon::now()->subDays(300);
      $post-&gt;category_id = 2;
      $post-&gt;save();
    }
  }
</pre>

Now, to run the seed action, you can use the next to commands:
<pre>
  <b>php artisan db:seed</b>
  or 
  <b>php artisan migrate:refresh --seed</b> 
</pre>

#### Create Tags with relations - Belongs To Many

First of all, we need to create the Tags model with the following command. This one, will create the model file and the migration "-m":

<pre>
  php artisan make:model Tag -m
</pre>

After that, we need to go to the migration to add the **name** field inside it:

<pre>
  public function up()
  {
    Schema::create('tags', function (Blueprint $table) {
      $table->increments('id');
      <b>$table->string('name');</b>
      $table->timestamps();
    });
  }  
</pre>

After that, we will run the Tags table migration, to build the table inside our DB system:

<pre>
  php artisan migrate
</pre>

Now we need to create the a table that will be storing the reference id records of each model data that will be added on the system:

<pre>
  php artisan make:migration create_post_tag_table --create=post_tag
</pre>

Now, we will open the last migration which we create before and going to add the new column fields we need to this table:

<pre>
    public function up()
    {
      Schema::create('post_tag', function (Blueprint $table) {
        $table->increments('id');
        <b>
        $table->unsignedInteger('post_id');
        $table->unsignedInteger('tag_id');
        </b>
        $table->timestamps();
      });
    }
</pre>

After that, we run the migrate command to create the intermediate table which will be filled with the references of any new tag will be added on our posts:

<pre>
  php artisan migrate
</pre>

After that, to set the **Model Relation** we need to go to the Post Model and insert the following code which is basically, create a new method to handle the relation between the model Post and the model Tag.

<pre>
  public function tags() { 
    return $this-> belongsToMany(Tag::class);
  }   
</pre>

Next, in the views we need to add the following code inside the rendered content:

<pre>
  @foreach($post->tags as $tag)
    <b>&lt;span class="tag c-gris"&gt; #{{ $tag->name }} &lt;/span&gt;</b>
  @endforeach
</pre>

#### Creating an Admin Side with ADMINLTE

After improve the views with the content which will be neccesary to show, we have to create the internal system, which will be responsible to handle each modification to our DB records.

To improve this environment, we need to download the [Admin LTE](https://adminlte.io/) template with all of their features.  

Inside our project, we need to open the **Public** folder and create another who calls **adminlte**:

<pre>
  cd public
  mkdir adminlte
</pre>

After that, we need to go to the folder from AdminLTE template and get the files which are stored inside the **dist** folder to paste it inside the **public/adminlte** folder.

* css
* img
* js

And from the begining of our **AdminLTE** folder, we have also copy the next folder:

* bower_components

Now, from this place, we need to start to code the template we will use to our dashboard system. To start to build our dashboard system, we can use the **starter.html** file what is stored on the root  **AdminLTE** folder. We need to copy the whole file structure and next, we have to create a new folder inside **Views** called **admin** where will also create a file called **layour.blade.php**. Inside of it, we will copy the whole code we got of our starter file.

<pre>
  cd views
  mkdir <b>admin</b>
  touch <b>layout.blade.php</b>
</pre>

Now, to get ready whole of the depencies from this template, we need to reset some routes of any folders. In the next, we show you which ones have to be changed and also from where have to be changed.

<pre>
  &lt;html&gt;
  &lt;head&gt;
  &nbsp;
    &lt;link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"&gt;
    &lt;link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css"&gt;
    &lt;link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css"&gt;
    &lt;link rel="stylesheet" href="dist/css/AdminLTE.min.css"&gt;
    &lt;link rel="stylesheet" href="dist/css/skins/skin-blue.min.css"&gt;
    &nbsp;
    to
    &nbsp;
    <b>
    &lt;link rel="stylesheet" href="/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css"&gt;
    &lt;link rel="stylesheet" href="/adminlte/bower_components/font-awesome/css/font-awesome.min.css"&gt;
    &lt;link rel="stylesheet" href="/adminlte/bower_components/Ionicons/css/ionicons.min.css"&gt;
    &lt;link rel="stylesheet" href="/adminlte/css/AdminLTE.min.css"&gt;
    &lt;link rel="stylesheet" href="/adminlte/css/skins/skin-blue.min.css"&gt;
    </b>
    &nbsp;
    [ PAGE CONTENT ]
    &nbsp;
    &lt;script src="bower_components/jquery/dist/jquery.min.js"&gt;&lt;/script&gt;
    &lt;script src="bower_components/bootstrap/dist/js/bootstrap.min.js"&gt;&lt;/script&gt;
    &lt;script src="dist/js/adminlte.min.js"&gt;&lt;/script&gt;
    </b>
    to
    <b>
    &lt;script src="/adminlte/bower_components/jquery/dist/jquery.min.js"&gt;&lt;/script&gt;
    &lt;script src="/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"&gt;&lt;/script&gt;
    &lt;script src="/adminlte/js/adminlte.min.js"&gt;&lt;/script&gt;
    </b>
  &lt;/body&gt;
  &lt;/html&gt;
</pre>

Next, inside the class **content** from this template, we need to insert the yield helper to insert the different content we will display inside of it:

<pre>
  &lt;section class="content"&gt;
    @yield('content')
  &lt;/section&gt;  
</pre>

After that, we will to create a file who will serve the different content our views will display:

<pre>
  cd views/admin
  touch dashboard.blade.php
</pre>

And inside of it, we will extend the layout template and also, the content from the *admin layout* who will show us the header, the sidebar and other tools we going to can handle on the admin area.

<pre>
  touch views/admin/dashboard.blade.php

  @extends('admin.layout')

  @section('content')
    &lt;h1&gt;Dashboard&lt;/h1&gt;
  @stop
</pre>

But even after to do this step, we need to add other element on our routes, because even we build this great system, we didn't set a route which one we can see this page. So, we will have to go to the **routes** file.

<pre>
  Route::get('admin', function() {
    return view('admin.dashboard');
  });  
</pre>

Now, if we visit the address **http://127.0.0.1:8000/admin** we will can see our dashboard working.

#### Creation of Login System

To create our login system, we can use the following command:

<pre>
  <b>php artisan make:auth --views</b>
  Authentication scaffolding generated successfully.
</pre>

This will respond with a new views which will created with the last command. The layout wil be placed on a folder called **layouts** and the main others like registration and login were be stored on **auth** folder.

<pre>
  auth
    |_passwords
    |   |_ email.blade.php
    |   |_ reset.blade.php
    login.blade.php
    register.blade.php
  layouts
    |_ app.blade.php
</pre>

After that, we need to insert the new route to our routes control.

<pre>
  <b>Route::auth();</b>
</pre>

#### Modifying the Login / Register Views

First we need to modify the **extends helpers** to our auth views to make the login views display like our admin platform.

<pre>
  cd resources/views/auth/<b>login.blade.php</b>

  @extends('layouts.app') =&gt; @extends('admin.layout')
</pre> 



#### To disable Register Form

To disable the register records, push **CMD + P** to found a file **Router.php** called adding the word **routing router**:

<pre>
  ublog/vendor/laravel/framework/src/illuminate/Routing/Router.php
</pre>

And for search the method, add the push again **CMD + P** and add **'@'** sign to look for the **auth method**:

<pre>
  public function auth()
  {
    // Authentication Routes...
    $this-&gt;get('login', 'Auth\LoginController@showLoginForm')-&gt;name('login');
    $this-&gt;post('login', 'Auth\LoginController@login');
    $this-&gt;post('logout', 'Auth\LoginController@logout')-&gt;name('logout');
    <b>
    // Registration Routes...
    // $this-&gt;get('register', 'Auth\RegisterController@showRegistrationForm')-&gt;name('register');
    // $this-&gt;post('register', 'Auth\RegisterController@register');
    </b>
    // Password Reset Routes...
    $this-&gt;get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')-&gt;name('password.request');
    $this-&gt;post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')-&gt;name('password.email');
    $this-&gt;get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')-&gt;name('password.reset');
    $this-&gt;post('password/reset', 'Auth\ResetPasswordController@reset');
  }  
</pre>

Now, to create a user to test our forms, we need to go the terminal and open the Laravel Console to do that:

<pre>
php artisan tinker
$user = new App\User;
=&gt; App\User {#751}
$user-&gt;name = "William"
=&gt; "William"
$user-&gt;email = "test@gmail.com"
=&gt; "test@gmail.com"
$user-&gt;password = bcrypt('1234')
=&gt; "$2y$10$xbPHecv2MzdNtpBoQKiPa.4LoV7AD7p04Hfb666H/.gQqFV7QxHGa"
$user-&gt;save()
=&gt; true
</pre>

After that, we will change the route we build to the admin site with the route home pointing to admin.dashboard:

<pre>
Route::get('home', function() {
  return view('admin.dashboard');
});
</pre>

## DEPLOY APP ON SERVER

* Create database
* Run migration

<pre>

  curl -sS https://getcomposer.org/installer | php
  sudo mv composer.phar /usr/local/bin/composer


  sudo chmod -R 775 /var/www/html/your-project/storage
  sudo chmod -R 755 /var/www/html/public/css
  sudo chmod -R 755 /var/www/html/public/img  
  sudo chmod -R 755 /var/www/html/public/adminLTE

  composer install
  composer update

  php artisan migrate
</pre>

