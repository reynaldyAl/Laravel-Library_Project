<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class StaffBookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->get();
        return view('staff.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('staff.books.create', compact('categories'));
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

        $imagePath = $request->file('image_path')->store('images', 'public');

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'published_year' => $request->published_year,
            'category_id' => $request->category_id,
            'available_copies' => $request->available_copies,
            'total_copies' => $request->total_copies,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('staff.books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('staff.books.edit', compact('book', 'categories'));
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
            $imagePath = $request->file('image_path')->store('images', 'public');
            $book->image_path = $imagePath;
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

        return redirect()->route('staff.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('staff.books.index')->with('success', 'Book deleted successfully.');
    }
}