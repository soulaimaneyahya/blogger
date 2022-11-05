<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Comment' => 'App\Policies\CommentPolicy',
        'App\Models\Group' => 'App\Policies\GroupPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('contact.admin', function($user) {
            if ($user->is_admin) {
                return true;
            }
        });

        // Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');

        // Gate::before(function($user, $ability) {
        //     if ($user->is_admin && in_array($ability, ['posts.update'])) {
        //         return true;
        //     }
        // });

        /*
        Gate::before(function($user, $ability) {
            if ($user->is_admin && in_array($ability, ['update-post'])) {
                return true;
            }
        });

        // Give admin ceratin permissions
        // if ($user->is_admin && in_array($ability, ['update-post', 'delete-post']))

        Gate::define('update-post', function($user, $post){
            return $post->user_id === $user->id;
        });
        
        Gate::define('delete-post', function($user, $post){
            return $post->user_id === $user->id;
        });

        Gate::after(function($user, $ability, $result) {
            if ($user->is_admin) {
                return true;
            }
        });
        */
    }
}
