<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use App\Models\BlogPost;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user(): User
    {
        return User::factory()->create();
    }

    protected function createDummyBlogPost(int $userId): BlogPost
    {
        return BlogPost::factory()->lorem()->create([
            'user_id' => $userId
        ]);
    }

    protected function blog_post(int $userId, int $count): BlogPost
    {
        return BlogPost::factory($count)->create([
            'user_id' => $userId
        ]);
    }
}
