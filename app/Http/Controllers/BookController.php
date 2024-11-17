<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     */
    public function index()
    {
        $books = Book::with(['category', 'reviews', 'loans'])->get();

        foreach ($books as $book) {
            $book->average_rating = $book->reviews->avg('rating');
            $book->loan_count = $book->loans->count();
            $book->popularity = $book->average_rating * 0.7 + $book->loan_count * 0.3;
        }

        $books = $books->sortByDesc('popularity');

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'available_copies' => 'required|integer',
            'total_copies' => 'required|integer',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book)
    {
        $book->load(['category', 'reviews', 'loans']);
        $book->average_rating = $book->reviews->avg('rating');
        $book->loan_count = $book->loans->count();
        $book->popularity = $book->average_rating * 0.7 + $book->loan_count * 0.3;

        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'available_copies' => 'required|integer',
            'total_copies' => 'required|integer',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}