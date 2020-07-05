<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        'name' => 'admin',
        'email' => 'admin@admin.com',
        'password' => Hash::make('123456789')
        ]);
        // $this->call(UserSeeder::class);
        $users = factory(App\User::class, 3)->create();
        $posts = factory(App\Post::class,20)->create();
        $comments = factory(App\Comment::class,50)->create();
    }
}
