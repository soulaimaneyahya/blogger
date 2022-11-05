<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;

class ActivityRepository
{
    /**
     * most posts has comments
     *
     * @return Collection
     */
    public function mostCommented(): Collection
    {
        return BlogPost::mostCommented()->get()->take(5);
    }

    /**
     * most active users
     *
     * @return Collection
     */
    public function mostActiveUsers(): Collection
    {
        return User::mostActiveUsers()->get()->take(5);
    }

    /**
     * most Active Last Month and their posts count
     */
    public function mostActiveLastMonth(): Collection
    {
        return User::mostActiveLastMonth()->get()->take(5);
    }
}
