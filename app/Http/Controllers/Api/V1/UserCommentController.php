<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\UserCommentResource;

class UserCommentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api')->only(['store', 'update', 'delete']);
    }
    /**
     * get user comments_on
     *
     * @param User $user
     * @return void
     */
    public function index(User $user, Request $request)
    {
        $per_page = $request->input('per_page') ?? 10;
        return UserCommentResource::collection(
            $user
            ->commentsOn()
            ->with('user')
            ->paginate($per_page) // paginate = 10
            ->appends([
                'per_page' => $per_page // &per_page=10
            ])
        );
    }

    /**
     * Store Comment Request
     *
     * @param StoreCommentRequest $request
     * @param User $user
     * @return void
     */
    public function store(StoreCommentRequest $request, User $user)
    {
        $data = [
            'content' => $request->content,
            'user_id' => auth()->id()
        ];
        $comment = $user->commentsOn()->create($data);
        return new UserCommentResource($comment);
    }

    /**
     * show comment
     *
     * @param User $user
     * @param Comment $comment
     * @return void
     */
    public function show(User $user, Comment $comment)
    {
        $comment = $user->commentsOn()->findOrFail($comment->id);
        return new UserCommentResource($comment);
    }

    /**
     * update comment
     *
     * @param StoreCommentRequest $request
     * @param User $user
     * @param Comment $comment
     * @return void
     */
    public function update(StoreCommentRequest $request, User $user, Comment $comment)
    {
        $this->authorize($comment);
        $comment->update([
            'content' => $request->content,
        ]);
        return new UserCommentResource($comment);     
    }

    /**
     * delete comment
     *
     * @param User $user
     * @param Comment $comment
     * @return void
     */
    public function destroy(User $user, Comment $comment)
    {
        $this->authorize($comment);
        $comment->delete();
        return response()->json([
            'status' => 204,
            'message' => 'Comment Deleted !'
        ]);
    }
}
