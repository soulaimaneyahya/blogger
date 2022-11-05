<?php

use App\Http\Controllers\BlogPostCommentController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\BlogPostTagController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/', [HomeController::class, 'home'])->name('home');

// posts
Route::GET('blog_posts/tags/{tag:name}', BlogPostTagController::class)->name('blog_posts.tags.index');
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);
Route::resource('blog_posts', BlogPostController::class);

// pages
Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('about-us', [HomeController::class, 'about'])->name('about.index');
Route::get('contact-us', [HomeController::class, 'contact'])->name('contact.index');
Route::POST('contact-us', [HomeController::class, 'store'])->name('contact.store');
Route::GET('contact-us/admin', [HomeController::class, 'admin'])->name('contact.admin')->middleware(['auth', 'can:contact.admin']);

Route::group(['middleware' => ['auth']], function(){
    Route::resource('blog_posts.comments', BlogPostCommentController::class)->only(['store']);
    Route::resource('users.comments', UserCommentController::class)->only(['store']);
    Route::resource('groups', GroupController::class)->only(['index', 'show']);
    Route::PUT('groups/{group}/join', JoinController::class)->name('groups.join');
    Route::PUT('users/{user}/follow', FollowController::class)->name('users.follow');
});
