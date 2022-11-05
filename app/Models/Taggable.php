<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taggable extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taggables';

    /**
     * Get the blog_post
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog_post()
    {
        return $this->belongsTo(BlogPost::class);
    }

    /**
     * Get the comment of this blog_post
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
