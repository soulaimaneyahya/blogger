<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description'
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, "group_user", "group_id", "user_id")->whereNull('group_user.deleted_at')->withTimestamps()->as('members');
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
