<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Http\Requests\StoreCommentRequest;
use App\Services\CommentService;

class BlogPostCommentController extends Controller
{
    /**
     * CommentService
     *
     * @param CommentService $commentService
     */
    public function __construct
    (
        private CommentService $commentService,
    )
    {
    }

    /**
     * @param StoreCommentRequest $request
     * @param BlogPost $blogPost
     * @return void
    */
    public function store(StoreCommentRequest $request, BlogPost $blogPost)
    {
        $data = [
            'content' => $request->content,
            'user_id' => auth()->id()
        ];

        $blogPost->comments()->create($data);
        // $this->commentService->store($data);
        return redirect()->back();
    }
}
