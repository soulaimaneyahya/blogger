<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\ProfileUser;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = Profile::all()->count();

        if (0 === $count) {
            $this->command->info('No profiles found, skipping assigning profiles to users');
            return;
        }

        $howManyMin = (int)$this->command->ask('Minimum profiles on users?', 0);
        $howManyMax = min((int)$this->command->ask('Maximum profiles on users?', $count), $count);

        $users = User::all();
        $data = [];
        foreach ($users as $user) {
            $profiles = Profile::all()->random(rand($howManyMin, $howManyMax))->pluck('id');
            foreach ($profiles as $profile) {
                $data[] = [
                    'profile_id' => $profile,
                    'user_id' => $user->id,
                    'created_at' => fake()->dateTimeBetween('-3 days'),
                    'updated_at' => fake()->dateTimeBetween('-3 days'),
                ];
            }
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            ProfileUser::insert($chunk);
        }

        /*
        User::all()->each(function (User $user) use($howManyMin, $howManyMax) {
            $profiles = Profile::all()->random(rand($howManyMin, $howManyMax))->pluck('id');
            $user->following()->sync($profiles);
        });
        */

        $profile = User::find(2)->profile;
        $followers = Profile::all()->pluck('id');
        $profile->followers()->attach($followers);
    }
}
