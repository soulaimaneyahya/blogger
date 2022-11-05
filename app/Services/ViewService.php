<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ViewService
{
    /**
     * how many users on the page
     *
     * @param integer $id
     * @return integer
     */
    public function view(int $id): int
    {
        $sessionId = session()->getId();
        $viewKey = "blog-post-{$id}-view";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::get($usersKey, []);
        $usersUpdate = [];
        $diffrence = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1) {
                $diffrence--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
        ) {
            $diffrence++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::forever($usersKey, $usersUpdate);

        if (!Cache::has($viewKey)) {
            Cache::forever($viewKey, 1);
        } else {
            Cache::increment($viewKey, $diffrence);
        }
        
        $view = Cache::get($viewKey);

        return $view;
    }
}
