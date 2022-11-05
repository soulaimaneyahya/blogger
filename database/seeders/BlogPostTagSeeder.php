<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use App\Models\Taggable;

class BlogPostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::all()->count();

        if (0 === $tagCount) {
            $this->command->info('No tags found, skipping assigning tags to blog posts');
            return;
        }

        $howManyMin = (int)$this->command->ask('Minimum tags on blog post?', 0);
        $howManyMax = min((int)$this->command->ask('Maximum tags on blog post?', $tagCount), $tagCount);

        $posts = BlogPost::all();
        $data = [];
        foreach ($posts as $post) {
            $tags = Tag::all()->random(rand($howManyMin, $howManyMax))->pluck('id');
            foreach ($tags as $tag) {
                $data[] = [
                    'tag_id' => $tag,
                    'taggable_id' => $post->id,
                    'taggable_type' => BlogPost::class,
                    'created_at' => fake()->dateTimeBetween('-3 weeks'),
                    'updated_at' => fake()->dateTimeBetween('-3 weeks'),
                ];
            }
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Taggable::insert($chunk);
        }
    }
}
