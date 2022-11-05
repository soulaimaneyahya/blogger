<?php

namespace App\Interfaces;

use App\Models\Tag;
use App\Models\BlogPost;

interface BlogPostInterface
{
    public function all();

    public function find(BlogPost $blogPost);

    public function findByTag(Tag $tag);
}
