<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class FollowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user)
    {
        auth()->user()->following()->toggle($user);
        return redirect()->route('users.show', $user);
    }
}
