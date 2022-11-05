<?php

namespace App\Observers;

use App\Models\Profile;

class ProfileObserver
{
    /**
     * Handle the Profile "updating" event.
     *
     * @param  \App\Models\Profile  $profile
     * @return void
     */
    public function updating(Profile $profile)
    {
        //
    }
}
