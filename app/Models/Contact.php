<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'subject',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function(BlogPost $post){
            $post->image()->delete();
        });
        static::restoring(function(BlogPost $post){
            $post->image()->restore();
        });
    }
}
