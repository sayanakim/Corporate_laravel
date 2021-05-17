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

//Route::get('/', function () {
//    return view('welcome');
//});
//
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::resource('/', \App\Http\Controllers\IndexController::class, [
    'only' => ['index'],
    'names' => [
        'index' => 'home'
    ]
]);

Route::resource('portfolios', \App\Http\Controllers\PortfolioController::class, [

    'parameters' => [

        'portfolios' => 'alias'

    ]

]);

Route::resource('articles', \App\Http\Controllers\ArticlesController::class, [

    'parameters' => [

        'articles' => 'alias'

    ]

]);
Route::get('articles/cat/{cat_alias?}', [\App\Http\Controllers\ArticlesController::class, 'index'])->name('articlesCat')->where('cat_alias', '[\w-]+');


Route::resource('comment', \App\Http\Controllers\CommentController::class, ['only' => ['store']]);

Route::match(['get', 'post'], '/contacts', [\App\Http\Controllers\ContactsController::class, 'index'])->name('contacts');




Route::name('admin.')->prefix('admin')->middleware('role:admin')->group( function () {

    //admin
    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('adminIndex');

    // articles
    Route::resource('/articles', \App\Http\Controllers\Admin\ArticlesController::class);

//    Route::resource('/permissions', );
//
//    Route::resource('/users', 'Admin\UsersController');
//
//    //menus
//    Route::resource('/menus', 'Admin\MenusController');

});


require __DIR__.'/auth.php';
