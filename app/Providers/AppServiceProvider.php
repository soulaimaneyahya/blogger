<?php

namespace App\Providers;

use App\Models\Profile;
use App\Observers\ProfileObserver;

use App\Observers\UserObserver;
use App\Models\User;

use App\Observers\ImageObserver;
use App\Models\Image;

use App\Models\Comment;
use App\Models\BlogPost;

use App\Observers\CommentObserver;
use App\Observers\BlogPostObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\UserCommentResource;
use App\Http\View\Composers\ActivityComposer;
use App\Http\Resources\BlogPostCommentResource;
use App\Http\Resources\BlogPostCommentUserResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // the key is too long for long indexes, so we can skip overriding it to 191
        Schema::defaultStringLength(191);
        // pagination
        Paginator::useBootstrap();

        // view composer, pass data to views globally
        View::composer('posts.partials._activity', ActivityComposer::class);

        // components aliases
        Blade::aliasComponent('components.badge', 'badge');
        Blade::aliasComponent('components.updated', 'updated');
        Blade::aliasComponent('components.card', 'card');
        Blade::aliasComponent('components.tags', 'tags');
        Blade::aliasComponent('components.errors', 'errors');
        Blade::aliasComponent('comments.comment-form', 'commentForm');
        Blade::aliasComponent('comments.comment-list', 'commentList');

        // observers
        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);
        User::observe(UserObserver::class);
        Profile::observe(ProfileObserver::class);
        Image::observe(ImageObserver::class);

        // data rest api wrapper
        BlogPostCommentResource::withoutWrapping();
        BlogPostCommentUserResource::withoutWrapping();
        UserCommentResource::withoutWrapping();
    }
}
