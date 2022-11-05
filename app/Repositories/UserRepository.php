<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserRepository
{
    public function __construct
    (
        private User $user,
        private Profile $profile,
    )
    {
    }

    public function find(User $user)
    {
        return $this->user->select(['name', 'id', 'username'])->withCount(['commentsOn', 'join', 'following'])->latest()->findOrFail($user->id);
    }

    public function profile(User $user)
    {
        return $this->profile->select(['description', 'url'])->withCount('followers')->findOrFail($user->id);
    }
}
