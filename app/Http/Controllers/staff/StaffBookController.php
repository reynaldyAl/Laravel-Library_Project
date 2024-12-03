<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StaffBookController extends Controller
{
    public function index()
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $books = Book::with('category')->get();
        return view('staff.books.index', compact('books'));
    }

    public function create()
    {
        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $categories = Category::all();
        return view('staff.books.create', compact('categories'));
    }

    public function store(Request $request)
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'available_copies' => 'required|integer',
            'total_copies' => 'required|integer',
            'synopsis' => 'required|string',
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
            'synopsis' => $request->synopsis,
            'image_path' => 'images/' . $imageName,
        ]);

        return redirect()->route('staff.books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $categories = Category::all();
        return view('staff.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'available_copies' => 'required|integer',
            'total_copies' => 'required|integer',
            'synopsis' => 'required|string',
            'image_path' => 'image',
        ]);

        if ($request->hasFile('image_path')) {
            // Delete the old image if it exists
            if ($book->image_path && file_exists(public_path($book->image_path))) {
                unlink(public_path($book->image_path));
            }

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
            'synopsis' => $request->synopsis,
            'image_path' => $book->image_path,
        ]);

        return redirect()->route('staff.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        // Delete the image if it exists
        if ($book->image_path && file_exists(public_path($book->image_path))) {
            unlink(public_path($book->image_path));
        }

        $book->delete();
        return redirect()->route('staff.books.index')->with('success', 'Book deleted successfully.');
    }
}