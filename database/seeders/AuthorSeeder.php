<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        $authors = [
            [
                'name' => 'John Doe',
                'bio' => 'Famous fiction writer with multiple bestsellers'
            ],
            [
                'name' => 'Jane Smith',
                'bio' => 'Science author and researcher'
            ],
            [
                'name' => 'Robert Johnson',
                'bio' => 'Technology expert and programming guru'
            ],
            [
                'name' => 'Maria Garcia',
                'bio' => 'Historical researcher and author'
            ],
            [
                'name' => 'David Brown',
                'bio' => 'Non-fiction writer specializing in self-help'
            ]
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}