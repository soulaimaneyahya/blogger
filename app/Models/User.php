<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Scopes\LatestScope;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'is_admin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function join()
    {
        return $this->belongsToMany(Group::class, "group_user", "user_id", "group_id")->whereNull('group_user.deleted_at')->withTimestamps()->as('join');
    }

    // following relationships
    public function following()
    {
        return $this->belongsToMany(Group::class, "profile_user", "user_id", "profile_id")->whereNull('profile_user.deleted_at')->withTimestamps()->as('following');
    }

    // user can make comments
    // field
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
    // table
    public function commentsOn()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    // local query scopes
    public function scopeMostActiveUsers(Builder $builder)
    {
        return $builder->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
    }

    public function scopeMostActiveLastMonth(Builder $builder)
    {
        return $builder->withCount(['blogPosts' => function($query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])
        ->having('blog_posts_count', '>=', 2)
        ->orderBy('blog_posts_count', 'desc');
    }

    public static function boot()
    {
        parent::boot();
        // register global scopes
        static::addGlobalScope(new LatestScope);
    }
}
