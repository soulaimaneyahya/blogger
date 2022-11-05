<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    /**
     * Handle the Comment "creating" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function creating(Comment $comment)
    {
        if ($comment->commentable_type == BlogPost::class) {
            
            Cache::forget("most-commented");
        }
    }

    /**
     * Handle the Comment "updating" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updating(Comment $comment)
    {
        if ($comment->commentable_type == BlogPost::class) {
            
            Cache::forget("most-commented");
        }
    }

    /**
     * Handle the Comment "deleting" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function deleting(Comment $comment)
    {
        if ($comment->commentable_type == BlogPost::class) {
            
            Cache::forget("most-commented");
        }
    }
}
