<?php

namespace App\Models;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Taggable;

    protected $fillable = [
        'user_id',
        'content'
    ];
    protected $dates = ['deleted_at'];
    protected $hidden = ['deleted_at', '', 'commentable_type', 'commentable_id', 'user_id'];

    // morph to many
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // local query scopes
    public function scopeLatest(Builder $builder)
    {
        // return $builder->orderBy(static::CREATED_AT, 'desc');
    }

    // repository format fct
    public function commentFormat()
    {
        return [
            'user_id' => $this->user_id,
            'post_id' => $this->commentable_id,
            'content' => $this->content,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
