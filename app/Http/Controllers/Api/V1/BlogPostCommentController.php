<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\BlogPostCommentResource;
use App\Models\Comment;

class BlogPostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }
    
    /**
     * Api data
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function index(BlogPost $blogPost, Request $request)
    {
        $perPage = $request->input('per_page') ?? 10;
        return BlogPostCommentResource::collection(
            $blogPost
            ->comments()
            ->with('user')
            ->paginate($perPage) // page=1
            ->appends([
                'per_page' => $perPage // &per_page=5
            ])
        );
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
        $comment = $blogPost->comments()->create($data);
        return new BlogPostCommentResource($comment);
    }

    /**
     * show comment
     *
     * @param BlogPost $blogPost
     * @param Comment $comment
     * @return void
     */
    public function show(BlogPost $blogPost, Comment $comment)
    {
        $comment = $blogPost->comments()->findOrFail($comment->id);
        return new BlogPostCommentResource($comment);
    }

    /**
     * update comment
     *
     * @param StoreCommentRequest $request
     * @param BlogPost $blogPost
     * @param Comment $comment
     * @return void
     */
    public function update(StoreCommentRequest $request, BlogPost $blogPost, Comment $comment)
    {
        $this->authorize($comment);
        $comment->update([
            'content' => $request->content,
        ]);
        return new BlogPostCommentResource($comment);
    }

    /**
     * delete post
     *
     * @param BlogPost $blogPost
     * @param Comment $comment
     * @return void
     */
    public function destroy(BlogPost $blogPost, Comment $comment)
    {
        $this->authorize($comment);
        $comment->delete();
        return response()->json([
            'status' => 204,
            'message' => 'Comment Deleted !'
        ]);
    }
}
