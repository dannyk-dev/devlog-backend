<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Technology',
            'Health',
            'Lifestyle',
            'Education',
            'Travel',
            'Food',
            'Business',
            'Entertainment',
            'Sports',
            'Science',
            'Finance',
            'Politics',
            'Culture',
            'Fashion',
            'Art',
            'DIY & Crafts',
            'Personal Development',
            'Automotive',
            'Parenting',
            'Environment',
            'Gaming',
            'Music',
            'Photography',
            'Real Estate',
            'Software Development',
            'Writing & Blogging',
            'Fitness',
            'History',
            'Books & Literature',
            'Movies & TV',
        ];

        foreach ($categories as $category)
        {
            Category::create(['name' => $category]);
        }
    }
}
