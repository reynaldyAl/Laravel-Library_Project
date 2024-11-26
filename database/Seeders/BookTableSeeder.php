<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Review;

class BookTableSeeder extends Seeder
{
    public function run()
    {
        $book1 = Book::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'publisher' => 'Scribner',
            'published_year' => 1925,
            'category_id' => 1,
            'available_copies' => 5,
            'total_copies' => 10,
            'image_path' => 'images/great_gatsby.jpg',
            'synopsis' => 'A novel about the American dream and the roaring twenties.',
        ]);



        $book2 = Book::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'publisher' => 'J.B. Lippincott & Co.',
            'published_year' => 1960,
            'category_id' => 2,
            'available_copies' => 3,
            'total_copies' => 7,
            'image_path' => 'images/to_kill_a_mockingbird.jpg',
            'synopsis' => 'A powerful story about justice and morality in the American South.',
        ]);



        $book3 = Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'publisher' => 'Secker & Warburg',
            'published_year' => 1949,
            'category_id' => 3,
            'available_copies' => 4,
            'total_copies' => 8,
            'image_path' => 'images/1984.jpg',
            'synopsis' => 'A chilling dystopian novel that remains relevant today.',
        ]);

        $book4 = Book::create([
            'title' => 'Harry Potter and the Philosopher\'s Stone',
            'author' => 'J.K. Rowling',
            'publisher' => 'Bloomsbury',
            'published_year' => 1997,
            'category_id' => 3,
            'available_copies' => 10,
            'total_copies' => 15,
            'image_path' => 'images/Harry_Potter.jpg',
            'synopsis' => 'After all this time? Always.',
        ]);

        

        // add reviews
        $book1->reviews()->createMany([
            [
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'A classic novel that everyone should read.',
            ],
            [
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'A great book with a lot of depth.',
            ],
        ]);
    }
}