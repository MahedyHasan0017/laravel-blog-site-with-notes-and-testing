<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $me = DB::table('users')->insert([
            'name' => "mhdy",
            'email' => "mhdy@gmail.com",
            'email_verified_at' => now(),
            'password' => Hash::make('11111111'), // password
            'remember_token' => Str::random(10),
            'is_admin' => true 
        ]);

        $others = User::factory()->count(20)->create();

        $users = $others->concat([$me]);


        $posts = BlogPost::factory()->count(40)->make()->each(function ($post) use ($users) {
            $post->user_id = User::all()->random()->id;
            $post->save();
        });

        $comments = Comment::factory()->count(140)->make()->each(function ($comment) use ($posts) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
