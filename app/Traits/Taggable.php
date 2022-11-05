<?php

namespace App\Traits;

use App\Models\Tag;

trait Taggable
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->whereNull('taggables.deleted_at')->withTimestamps()->as('tagged');
    }
}
