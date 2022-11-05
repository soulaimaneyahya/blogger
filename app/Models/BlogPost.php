<?php

namespace App\Models;

use App\Traits\Taggable;
use App\Scopes\LatestScope;
use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes, Taggable;
    protected $table = "blog_posts";
    protected $fillable = [
        'user_id',
        'title',
        'content'
    ];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    // many to many
    // public function tags()
    // {
    //     return $this->belongsToMany(Tag::class, "blog_post_tag", "blog_post_id", "tag_id")->whereNull('blog_post_tag.deleted_at')->withTimestamps()->as('posted');
    // }

    // repository format fct
    public function postFormat()
    {
        return [
            'post_title' => $this->title,
            'author' => $this->user->name,
        ];
    }

    // local query scopes
    public function scopeLatest(Builder $builder)
    {
        // return $builder->orderBy(static::CREATED_AT, 'desc');
    }
    public function scopeMostCommented(Builder $builder)
    {
        return $builder->withCount('comments')->orderBy('comments_count', 'desc');
    }
    public function scopeLatestWithRelations(Builder $builder)
    {
        return $builder->with(['user', 'tags'])->withCount('comments')->latest();
    }

    public static function boot()
    {
        // before parent boot, in cause of soft deletes
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();

        // register global scopes
        static::addGlobalScope(new LatestScope);
    }
}
