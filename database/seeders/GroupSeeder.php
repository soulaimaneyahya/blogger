<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = max((int)$this->command->ask("How many groups would you like ?", 1000), 1);
                
        $data = [];
        for ($i=0; $i < $count; $i++) { 
            $data[] = [
                'name' => fake()->sentence($nbWords = 4),
                'description' => fake()->text($maxNbChars = 500),
                'created_at' => fake()->dateTimeBetween('-3 weeks'),
                'updated_at' => fake()->dateTimeBetween('-3 weeks'),
            ];
        }
        // 1ms
        Group::insert($data);
    }
}
