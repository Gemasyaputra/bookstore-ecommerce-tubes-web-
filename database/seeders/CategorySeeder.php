<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // [
            //     'name' => 'Fiction',
            //     'slug' => 'fiction',
            //     'description' => 'Fictional stories and novels'
            // ],
            // [
            //     'name' => 'Non-Fiction',
            //     'slug' => 'non-fiction',
            //     'description' => 'Real-world facts and information'
            // ],
            // [
            //     'name' => 'Science',
            //     'slug' => 'science',
            //     'description' => 'Scientific books and research'
            // ],
            // [
            //     'name' => 'Technology',
            //     'slug' => 'technology',
            //     'description' => 'Programming and tech books'
            // ],
            // [
            //     'name' => 'History',
            //     'slug' => 'history',
            //     'description' => 'Historical books and biographies'
            // ],
            
            [
                'name' => 'Manga',
                'slug' => 'manga',
                'description' => 'Japanese comic books and graphic novels'
            ],
            
            [
                'name' => 'Romance',
                'slug' => 'romance',
                'description' => 'Romantic novels and love stories'
            ],
            
            [
                'name' => 'Horror',
                'slug' => 'horror',
                'description' => 'Scary stories and horror novels'
            ],
            

        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}