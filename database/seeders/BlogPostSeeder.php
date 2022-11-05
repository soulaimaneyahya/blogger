<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = max((int)$this->command->ask("How many blog_posts would you like ?", 1000), 1);
        $users = collect(User::all()->modelKeys());
        
        $data = [];
        for ($i=0; $i < $count; $i++) { 
            $data[] = [
                'user_id' => $users->random(),
                'title' => fake()->sentence($nbWords = 4),
                'content' => fake()->text($maxNbChars = 500),
                'created_at' => fake()->dateTimeBetween('-3 weeks'),
                'updated_at' => fake()->dateTimeBetween('-3 weeks'),
            ];
        }
        // 1ms
        BlogPost::insert($data);
        // foreach (array_chunk($data, 1000) as $chunk) {
        //     BlogPost::insert($chunk);
        // }

        /* 174 seconds
        $posts = BlogPost::factory($count)->make()->each(function($post) use($users) {
            $post->user_id = $users->random();
            $post->save();
        });
        */
    }
}
