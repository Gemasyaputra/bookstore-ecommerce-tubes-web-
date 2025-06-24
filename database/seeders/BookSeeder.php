<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                'title' => 'The Great Adventure',
                'slug' => 'the-great-adventure',
                'description' => 'An amazing fictional story about adventure and discovery.',
                'price' => 25.99,
                'stock' => 50,
                'isbn' => '9781234567890',
                'category_id' => 1, // Fiction
                'author_id' => 1    // John Doe
            ],
            [
                'title' => 'Science Explained',
                'slug' => 'science-explained',
                'description' => 'A comprehensive guide to understanding modern science.',
                'price' => 35.50,
                'stock' => 30,
                'isbn' => '9781234567891',
                'category_id' => 3, // Science
                'author_id' => 2    // Jane Smith
            ],
            [
                'title' => 'Programming Mastery',
                'slug' => 'programming-mastery',
                'description' => 'Learn programming from beginner to advanced level.',
                'price' => 45.00,
                'stock' => 25,
                'isbn' => '9781234567892',
                'category_id' => 4, // Technology
                'author_id' => 3    // Robert Johnson
            ],
            [
                'title' => 'World History Chronicles',
                'slug' => 'world-history-chronicles',
                'description' => 'Comprehensive overview of world history events.',
                'price' => 30.75,
                'stock' => 40,
                'isbn' => '9781234567893',
                'category_id' => 5, // History
                'author_id' => 4    // Maria Garcia
            ],
            [
                'title' => 'Self Improvement Guide',
                'slug' => 'self-improvement-guide',
                'description' => 'Transform your life with practical advice.',
                'price' => 22.99,
                'stock' => 60,
                'isbn' => '9781234567894',
                'category_id' => 2, // Non-Fiction
                'author_id' => 5    // David Brown
            ],
            [
                'title' => 'Mystery of the Lost City',
                'slug' => 'mystery-of-the-lost-city',
                'description' => 'A thrilling mystery novel set in ancient times.',
                'price' => 28.50,
                'stock' => 35,
                'isbn' => '9781234567895',
                'category_id' => 1, // Fiction
                'author_id' => 1    // John Doe
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}