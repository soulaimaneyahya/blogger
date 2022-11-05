<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\UpdateUserRequest;
use App\Services\CommentService;

class UserController extends Controller
{
    public function __construct
    (
        private UserService $userService,
        private CommentService $commentService,
    )
    {
        $this->middleware('auth')->only(['update']);
    }
    public function show(User $user): View
    {
        $user = $this->userService->find($user);
        $profile = $this->userService->profile($user);
        $comments = $this->commentService->find($user, User::class);
        return view('users.show', compact('user', 'comments', 'profile'));
    }

    public function edit(User $user): View
    {
        $this->authorize($user);
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize($user);
        $data = $request->validated();
        $this->userService->update($data, $user);
        return redirect()->route('users.show', $user)->with('alert-success', 'User Updated !');
    }
}
