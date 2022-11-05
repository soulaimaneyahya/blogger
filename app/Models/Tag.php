<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "tags";
    protected $fillable = [
        'name'
    ];
    protected $dates = ['deleted_at'];

    /*
    public function blog_posts()
    {
        return $this->belongsToMany(BlogPost::class, "blog_post_tag", "tag_id", "blog_post_id")->whereNull('blog_post_tag.deleted_at')->withTimestamps()->as('tagged');
    }
    */

    public function blog_posts()
    {
        return $this->morphedByMany(BlogPost::class, "taggable")->whereNull('taggables.deleted_at')->withTimestamps()->as('tagged');
    }

    public function comments()
    {
        return $this->morphedByMany(Comment::class, "taggable")->whereNull('taggables.deleted_at')->withTimestamps()->as('tagged');
    }
}
