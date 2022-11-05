<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreCommentRequest;

class UserCommentController extends Controller
{
    /**
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
        $user->commentsOn()->create($data);
        return redirect()->back();
    }
}
