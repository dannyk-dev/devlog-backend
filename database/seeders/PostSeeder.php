<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $blogs = \App\Models\Blog::all();
        $users = \App\Models\User::all();
        $categories = \App\Models\Category::all();

        foreach ($users as $user)
        {
            $category = $categories->random();

            \App\Models\Post::factory(2)->create([
                'user_id' => $user->id,
                'category_id' => $category->id
            ]);
        }
    }
}
