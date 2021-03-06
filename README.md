#### Create LARAVEL APP

<pre>
  laravel new <b>name_test_app</b>
</pre>

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

Now, after we build the login, the predefined route and the user, we can login on our form and it will send us to the dashboard. On this, we can add our name to know that we are already authenticated.

<pre>
  views/admin/layout.blade.php

  <b>
  {{ auth()->user()->name }}
  </b>
</pre>

#### Using Middleware to prevent non-authorized views

To keep the dashboard views safe to our guests, we can add a Middleware, which is a function who do an action just if a statement is true. In this case, our middleware will be called **auth**. This middleware is a public method from the **Auth** system that Laravel uses to handle the login/registration tasks.

<pre>
  routes/web.php

  Route::get('home', function() {
    return view('admin.dashboard');
  })<b>->middleware('auth');</b>
</pre>

Now, if we loose our session or this expires, we will be redirected to login view.


#### Working Sidebar with Partials

To handle pieces of blocks whose going to be used on as a important items from a more bigger structure, we use  **partials**. The idea is split the relevant contents to get a more structured view to read and work and for **reuse the sidebar element** inside of all our internal views. To create a partial, we will create a folder on our admin folder, which will be called **partials**, and inside, we will add the **sidebar** html code. After that, we will insert this part of code on the layout were was placed to keep this component on our view.

<pre>
  cd views/admin/
  mkdir partials
  touch nav.blade.php

  ** COPY THE SIDEBAR CODE **
</pre>

So, we have to add this **sidebar** on the layout file from our admin (dashboard) were was placed:

<pre>
  <!-- Sidebar Menu -->
  @include('admin.partials.nav')
  <!-- /.sidebar-menu -->
</pre>

#### Handle sidebar actions with Controllers:

We need  handle our frontpage views, so we will create a controller called **PagesController** which will serve the index page, contact page and the others.
[Controllers Laravel](https://laravel.com/docs/5.5/controllers#resource-controllers)

<pre>
  php artisan make:controller PagesController
</pre>

And we will create a **PagesController.php** file. Now, we will add the instances variables we are getting from **Post Model** to display on the index page or root route. To do that, we need to go to our **routes file** to get the elements are declared inside the "*/*" address (root address) and we will point this action to the **PagesController** to serve the data was setted on our routes file.

<pre>
  routes/<b>web.php</b>

  use Carbon\Carbon;

  // Route::get('/', function () {
  //   $today = Carbon::today();
  //   $posts = App\Post::latest('published_at')->get();
  //   return view('welcome', compact('posts', 'today'));
  // }); 

  TO:

  <b>Route:get('/', 'PagesController@index');</b>

  AND:

  app/Htptp/Controllers/<b>PagesController.php</b>

  &lt;?php
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

</pre>

To handle a new controller, first of all, we need to create an **posts folder** inside of admin main folder, to build the views we will use to create, display and update our posts.
 
After that, we will use the command **make:controller** to create our posts internal views.

<pre>
  touch resources/views/admin/<b>posts/index.blade.php</b>
  php artisan make:controller Admin/PostsController
</pre>

It will create our new Posts Controller, whose will be stored on our **Admin** folder, because will be used to handle the internal views to our projects related to the posts. After run this command, the command will create the file with the **namespace** pre-routed to our **Admin** folder.

Now inside our Posts Controller, we will be able to create the necessary views to handle a REST architecture. The first view we will create will be the index, so we need to add a public function called **index()** and also, add the view route on our router file.

<pre>
  app/Http/Controllers/Admin/<b>PostsController.php</b>

  <?php

  namespace App\Http\Controllers\Admin;
  use Illuminate\Http\Request;
  use App\Http\Controllers\Controller;
  <b>
  class PostsController extends Controller
  {
    public function index() {
      return view('admin.posts.index');
    }
  }
  </b>
</pre>

And, we have to declare the routes to handle the views.

<pre>
  ublog/routes/<b>web.php</b>
  
  <b>
  Route::get('admin/posts', 'Admin\PostsController@index');
  </b>

  OR CREATE A GROUP FOR EVERY ROUTE WHICH USES THE PREFIX AND NAMESPACE ADMIN:
  
  <b>
  Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function (){
    Route::get('posts', PostsController@index)->name('admin.posts.index');
  });
  </b>
</pre>

To add the link to the main admin posts view, we can use the route helper to add it on the link of the nav:

<pre>
  &lgt;ul class="treeview-menu"&gt;
    &lgt;li&gt;&lgt;a href="{{ route('admin.posts.index') }}"&gt;&lgt;i class="fa fa-eye"&gt;&lgt;/i&gt;Ver posts&lgt;/a&gt;&lgt;/li&gt;
    &lgt;li&gt;&lgt;a href="#"&gt;&lgt;i class="fa fa-pencil"&gt;&lgt;/i&gt;Crear posts&lgt;/a&gt;&lgt;/li&gt;
  &lgt;/ul&gt;
</pre>













## DEPLOY APP ON SERVER

* Create database
* Run migration

<pre>

  curl -sS https://getcomposer.org/installer | php
  sudo mv composer.phar /usr/local/bin/composer

  sudo chown -R www-data: storage
  sudo chmod -R 775 /var/www/html/your-project/storage
  sudo chmod -R 755 /var/www/html/public/css
  sudo chmod -R 755 /var/www/html/public/img  
  sudo chmod -R 755 /var/www/html/public/adminLTE

  composer install
  composer update

  php artisan migrate
</pre>

