<?php

namespace Database\Seeders;

use Database\Factories\BlogFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        $categories = \App\Models\Category::all();

        for ($i = 0; $i < 50; $i++)
        {
            $user = $users->random();
            $category = $categories->random();

            // echo $user;

            \App\Models\Blog::factory()->create([
                'user_id' => $user->id,
                'category_id' => $category->id
            ]);
        }
    }
}
