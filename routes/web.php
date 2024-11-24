<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ThemeController;
use App\Models\Blog;
use App\Models\Subscriber;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $blogs=Blog::paginate(4);
    return view('themes.home', compact('blogs'));
});


Route::controller(ThemeController::class)->name('theme.')->group(function () {
    Route::get('/home','home')->name('homepage');
    Route::get('/category/{id}','category')->name('categorypage');
    Route::get('/contact','contact')->name('contactpage');

//     Route::get('/register','register')->name('registerpage');
//     Route::get('/login','login')->name('loginpage');
    });

Route::post('/subscriber/store' , [SubscriberController::class , 'store'])->name('subscriber.store');
Route::post('/contact/store' , [ContactController::class , 'store'])->name('contact.store');

Route::get('/my-blogs',[BlogController::class,'myblogs'])->name('blogs.my-blogs');
Route::resource('/blogs' ,BlogController::class);
Route::post('/singleblog/comments',[CommentController::class , 'store'])->name('comments.store');




// ---------------------------------built in----------------------------------------------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
