<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    /**
     * Handle the BlogPost "creating" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost)
    {
        Cache::forget("most-commented");
        Cache::forget("most-active-users");
        Cache::forget("most-active-last-month");
    }

    /**
     * Handle the BlogPost "updating" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function updating(BlogPost $blogPost)
    {
        Cache::forget("most-commented");
        Cache::forget("most-active-users");
        Cache::forget("most-active-last-month");
        
    }

    /**
     * Handle the BlogPost "deleting" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleting(BlogPost $blogPost)
    {
        Cache::forget("most-commented");
        Cache::forget("most-active-users");
        Cache::forget("most-active-last-month");
        $blogPost->comments()->delete();
        $blogPost->image()->delete();
        
    }

    /**
     * Handle the BlogPost "restoring" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restoring(BlogPost $blogPost)
    {
        Cache::forget("most-commented");
        Cache::forget("most-active-users");
        Cache::forget("most-active-last-month");
        
        $blogPost->comments()->restore();
        $blogPost->image()->restore();
    }
}
