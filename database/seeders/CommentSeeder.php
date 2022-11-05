<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = max((int)$this->command->ask("How many comments would you like ?", 10000), 2);
        $posts = collect(BlogPost::all()->modelKeys());
        $users = collect(User::all()->modelKeys());

        $users_comments = [];
        for ($i=0; $i < $count; $i++) { 
            $users_comments[] = [
                'content' => fake()->text($maxNbChars = 200),
                'created_at' => fake()->dateTimeBetween('-3 days'),
                'updated_at' => fake()->dateTimeBetween('-3 days'),
                'user_id' => $users->random(),
                'commentable_id' => $users->random(),
                'commentable_type' => User::class,
            ];
        }
        // 1ms
        foreach (array_chunk($users_comments, 500) as $chunk) {
            Comment::insert($chunk);
        }

        $posts_comments = [];
        for ($i=0; $i < $count; $i++) { 
            $posts_comments[] = [
                'content' => fake()->text($maxNbChars = 200),
                'created_at' => fake()->dateTimeBetween('-3 days'),
                'user_id' => $users->random(),
                'commentable_id' => $posts->random(),
                'commentable_type' => BlogPost::class,
            ];
        }
        // 1ms
        // Comment::insert($posts_comments);
        foreach (array_chunk($posts_comments, 500) as $chunk) {
            Comment::insert($chunk);
        }

        // comments
        /*
        // minutes
        \App\Models\Comment::factory($count)->make()->each(function($comment) use($posts, $users){
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $users->random()->id; // any user can add comment, not necessary post ownero
            $comment->save();
        });
        \App\Models\Comment::factory($count)->make()->each(function ($comment) use ($users) {
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = User::class;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
        */
    }
}
