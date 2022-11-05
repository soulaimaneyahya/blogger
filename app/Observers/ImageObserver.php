<?php

namespace App\Observers;

use App\Models\Image;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class ImageObserver
{
        /**
     * Handle the Image "updating" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function updating(Image $image)
    {
        foreach (BlogPost::all() as $post) {
            //
        }
    }
}
