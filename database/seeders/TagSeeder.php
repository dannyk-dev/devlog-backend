<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tags = ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'CSS', 'HTML'];

        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }
    }
}
