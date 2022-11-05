<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Repositories\ActivityRepository;

class ActivityComposer
{
    public function __construct(
        private ActivityRepository $activityRepository,
    )
    {
        //
    }

    public function compose(View $view)
    {
        $mostCommented = Cache::remember('most-commented', now()->addSeconds(20), function(){
            return $this->activityRepository->mostCommented();
        });
        $mostActiveUsers = Cache::remember('most-active-users', now()->addSeconds(20), function(){
            return $this->activityRepository->mostActiveUsers();
        });
        $mostActiveLastMonth = Cache::remember('most-active-last-month', now()->addSeconds(20), function(){
            return $this->activityRepository->mostActiveLastMonth();
        });
        
        $view->with('mostCommented', $mostCommented);
        $view->with('mostActiveUsers', $mostActiveUsers);
        $view->with('mostActiveLastMonth', $mostActiveLastMonth);
    }
}
