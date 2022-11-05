<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['php', 'javascript', 'html', 'css', 'laravel', 'aws', 'vuejs', 'reactjs', 'symfony', 'java', 'android', 'myql'];
        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag
            ]);
        }
    }
}
