<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\BlogPost;
use App\Interfaces\BlogPostInterface;
use Illuminate\Support\Facades\Cache;

class BlogPostRepository implements BlogPostInterface
{
    public function __construct
    (
        private BlogPost $blogPost,
    )
    {
    }

    public function all()
    {
        $per_page = request('per_page') ?? 10;
        $q = request('q');
        $posts = $this->blogPost->select(['id', 'user_id', 'title', 'content', 'created_at'])->latestWithRelations();
        if ($q) {
            $posts = $posts->where('title', 'like', '%'. $q .'%');
        }
        return $posts
        ->paginate($per_page) // page = 1
        ->appends([
            'q' => $q, // &q=lorem
            'per_page' => $per_page, // &per_page=10
        ]);
    }

    public function findByTag(Tag $tag)
    {
        $per_page = request('per_page') ?? 10;
        $q = request('q');
        $posts = $tag->blog_posts()
            ->latestWithRelations()->select(['blog_posts.id', 'blog_posts.user_id', 'blog_posts.title', 'blog_posts.content', 'blog_posts.created_at']);
        if ($q) {
            $posts = $posts->where('title', 'like', '%'. $q .'%');
        }

        return $posts
            ->paginate($per_page) // page = 1
            ->appends([
                'q' => $q, // & q=lorem
                'per_page' => $per_page, // & per_page=10
            ]);
    }

    public function find(BlogPost $blogPost)
    {
        // return Cache::remember("blog-post-{$blogPost->id}", now()->addSeconds(120), function() use ($blogPost){
        // });
        return $this->blogPost->with(['user', 'tags'])->select(['id', 'user_id', 'title', 'content', 'updated_at'])->withCount('comments')->latest()
        ->findOrFail($blogPost->id);
    }
}
