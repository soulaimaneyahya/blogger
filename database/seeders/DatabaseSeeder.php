<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you want to refresh the DB?')) {
            $this->command->call('migrate:fresh');
            $this->command->info('---------------------------------- database refreshed');
        }

        // remove ll items from cache
        // Cache::tags(['blog_post'])->flush();

        exec("sudo rm -rf /opt/lampp/htdocs/laravell/blogger/storage/app/public/*");
        exec("cd /opt/lampp/htdocs/laravell/blogger/storage/app/public && mkdir laravolt && mkdir avatars && mkdir contacts && mkdir thumbnails");
        exec("sudo chmod +777 -R /opt/lampp/htdocs/laravell/blogger/storage/app/public");

        $this->call([
            UsersTableSeeder::class, 
            BlogPostSeeder::class, 
            CommentSeeder::class,
            TagSeeder::class,
            BlogPostTagSeeder::class,
            GroupSeeder::class,
            UserGroupSeeder::class,
            UserProfileSeeder::class
        ]);
        $this->command->info("---------------------------------- thanks seeder");
    }
}
