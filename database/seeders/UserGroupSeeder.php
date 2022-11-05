<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gCount = Group::all()->count();

        if (0 === $gCount) {
            $this->command->info('No groups found, skipping assigning groups to users');
            return;
        }

        $howManyMin = (int)$this->command->ask('Minimum groups on user?', 0);
        $howManyMax = min((int)$this->command->ask('Maximum groups on user?', 10), $gCount);

        $users = User::all();
        $data = [];
        foreach ($users as $user) {
            $groups = Group::all()->random(rand($howManyMin, $howManyMax))->pluck('id');
            foreach ($groups as $group) {
                $data[] = [
                    'group_id' => $group,
                    'user_id' => $user->id,
                    'created_at' => fake()->dateTimeBetween('-3 days'),
                    'updated_at' => fake()->dateTimeBetween('-3 days'),
                ];
            }
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            GroupUser::insert($chunk);
        }
        
        //==
        /*
        User::all()->each(function (User $user) use($howManyMin, $howManyMax) {
            $tags = Group::all()->random(rand($howManyMin, $howManyMax))->pluck('id');
            $user->join()->sync($tags);
        });
        */
    }
}
