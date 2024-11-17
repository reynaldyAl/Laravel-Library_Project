<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index()
    {
        $books = Book::all();
        return view('home.index', compact('books'));
    }

    /**
     * Show the detail page for a book.
     */
    public function show(Book $book)
    {
        return view('home.detail', compact('book'));
    }
}