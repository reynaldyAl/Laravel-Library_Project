<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'reviews', 'loans'])->get();
        foreach ($books as $book) {
            $book->average_rating = $book->reviews->avg('rating');
            $book->loan_count = $book->loans->count();
            $book->popularity = $book->average_rating * 0.7 + $book->loan_count * 0.3;
        }
        $books = $books->sortByDesc('popularity');
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

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
            'image_path' => 'required|image',
        ]);

        $image = $request->file('image_path');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'published_year' => $request->published_year,
            'category_id' => $request->category_id,
            'available_copies' => $request->available_copies,
            'total_copies' => $request->total_copies,
            'image_path' => 'images/' . $imageName,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

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
            'image_path' => 'image',
        ]);

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $book->image_path = 'images/' . $imageName;
        }

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'published_year' => $request->published_year,
            'category_id' => $request->category_id,
            'available_copies' => $request->available_copies,
            'total_copies' => $request->total_copies,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
}