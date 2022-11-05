<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Laravolt\Avatar\Facade as Avatar;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = max((int)$this->command->ask("How many users would you like ?", 1000), 1);
        $john = \App\Models\User::factory()->john()->create();
        $admin = \App\Models\User::factory()->admin()->create();
        
        $data = [];
        for ($i=0; $i < $count; $i++) { 
            $data[] = [
                'name' => fake()->name(),
                'username' => fake()->unique()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'api_token' => Str::random(80),
                'remember_token' => Str::random(10),
                'created_at' => fake()->dateTimeBetween('-3 days'),
                'updated_at' => fake()->dateTimeBetween('-3 days'),
            ];
        }
        // 1ms
        User::insert($data);

        $users = User::all();
        $keys = [];

        foreach ($users as $key => $value) {
            if ($key != 0 && $key != 1) {
                $keys[] = ['user_id' => $value->id,];
            }
        }
        Profile::insert($keys);

        $users->each(function($user) use($keys){
            Avatar::create($user->name)->save(storage_path('app/public/laravolt/avatar-'. $user->id .'.png'));
        });
    }
}
