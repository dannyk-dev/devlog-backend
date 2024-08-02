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
        $blogs = \App\Models\Blog::all();

        foreach ($blogs as $blog)
        {
            \App\Models\Post::factory(2)->create([
                'title' => fake()->sentence(2),
                'description' => fake()->sentence(30),
                'content' => fake()->sentence(150),
                'blog_id' => $blog->id
            ]);
        }
    }
}
