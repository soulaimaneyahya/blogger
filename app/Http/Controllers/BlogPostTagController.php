<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\BlogPostService;

class BlogPostTagController extends Controller
{
    /**
     * blog post repository
     *
     * @param BlogPostService $blogPostService
     */
    public function __construct(
        private BlogPostService $blogPostService,
    )
    {
        //
    }

    /**
     * Get BlogPosts by Tag
     *
     * @param Tag $tag
     * @return void
     */
    public function __invoke(Tag $tag)
    {
        $blogPosts = $this->blogPostService->findByTag($tag);
        return view('posts.index', compact('blogPosts', 'tag'));
    }
}
