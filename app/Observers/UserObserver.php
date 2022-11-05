<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the User "updating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        //
    }

    /**
     * on user created
     *
     * @param User $user
     * @return void
     */
    public function created(User $user)
    {
        $user->profile()->create();
    }
}
