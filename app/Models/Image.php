<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['path'];
    protected $dates = ['deleted_at'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function url()
    {
        return Storage::url($this->path);
    }
}
