<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface ActivityInterface
{
    /**
     * most posts has comments
     *
     * @return Collection
     */
    public function mostCommented(): Collection;

    /**
     * most active users
     *
     * @return Collection
     */
    public function mostActiveUsers(): Collection;

    /**
     * most Active Last Month and their posts count
     */
    public function mostActiveLastMonth(): Collection;
}
