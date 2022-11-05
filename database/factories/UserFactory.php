<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'api_token' => Str::random(80),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'the admin',
                'username' => 'theadmin',
                'email' => 'admin@admin.com',
                'is_admin' => 1
            ];
        });
    }

    public function john()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'john doe',
                'username' => 'johndoe',
                'email' => 'johndoe@gmail.com'
            ];
        });
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Profile::create([
                // 'user_id' => $user->id,
                // 'description' => fake()->paragraph($nbSentences = 3),
                // 'url' => fake()->domainName(),
            // ]);
        });
    }
}
