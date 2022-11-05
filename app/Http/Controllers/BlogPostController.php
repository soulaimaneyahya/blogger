<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\BlogPost;
use App\Services\ViewService;
use App\Services\BlogPostService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Services\CommentService;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;

class BlogPostController extends Controller
{
    public function __construct(
        private BlogPostService $blogPostServices,
        private ViewService $viewService,
        private CommentService $commentService
    )
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index(): View
    {
        $blogPosts = $this->blogPostServices->all();
        return view('posts.index', compact('blogPosts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(StoreBlogPostRequest $request): RedirectResponse
    {
        $data = $request->validated() + [ 'user_id' => auth()->id()];
        $blogPost = $this->blogPostServices->store($data);
        return redirect()->route('blog_posts.edit', $blogPost)->with('alert-success', 'Post Created !');
    }

    public function show(BlogPost $blogPost): View
    {
        $blogPost = $this->blogPostServices->find($blogPost);

        $comments = $this->commentService->find($blogPost, BlogPost::class);

        $view = $this->viewService->view($blogPost->id);
        
        return view('posts.show', compact('blogPost', 'view', 'comments'));
    }

    public function edit(BlogPost $blogPost)
    {
        $this->authorize($blogPost);
        return view('posts.edit', compact('blogPost'));
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost): RedirectResponse
    {
        $this->authorize($blogPost);
        $data = $request->validated() + [ 'user_id' => auth()->id()];
        $blogPost = $this->blogPostServices->update($data, $blogPost);
        return redirect()->route('blog_posts.edit', $blogPost)->with('alert-success', 'Post Updated !');
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        $this->authorize($blogPost);
        $blogPost->delete();
        $this->blogPostServices->delete($blogPost);
        return redirect()->route('blog_posts.index')->with('alert-info', 'Post Deleted !');
    }
}
