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
        ]);

        Review::create([
            'user_id' => 1,
            'book_id' => $book1->id,
            'rating' => 5,
            'comment' => 'A classic novel with timeless themes.',
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
        ]);

        Review::create([
            'user_id' => 2,
            'book_id' => $book2->id,
            'rating' => 4,
            'comment' => 'A powerful story about justice and morality.',
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
        ]);

        Review::create([
            'user_id' => 3,
            'book_id' => $book3->id,
            'rating' => 5,
            'comment' => 'A chilling dystopian novel that remains relevant today.',
        ]);

        // Tambahkan lebih banyak buku dan ulasan sesuai kebutuhan
    }
}