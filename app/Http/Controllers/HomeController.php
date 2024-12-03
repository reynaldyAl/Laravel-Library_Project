<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Book::query();

        // Pencarian berdasarkan judul atau penulis
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        // Menampilkan buku terbaru (ditambahkan dalam 3 hari terakhir)
        $threeDaysAgo = Carbon::now()->subDays(3);
        $books = $query->where('created_at', '>=', $threeDaysAgo)
                       ->orderBy('created_at', 'desc')
                       ->take(10)
                       ->get();

        // Menampilkan buku populer (tidak termasuk buku yang baru ditambahkan)
        $popularBooks = Book::withCount('loans')
                            ->whereNotIn('id', $books->pluck('id')->toArray())
                            ->orderBy('loans_count', 'desc')
                            ->take(10)
                            ->get();

        return view('home.index', compact('books', 'popularBooks'));
    }

    //detail page
    public function show(Book $book)
    {
        $book->load('reviews.user'); // Load reviews with user
        return view('home.detail', compact('book'));
    }

    //book catalog
    public function catalog(Request $request)
    {
        $query = Book::query();

        // Filter berdasarkan kategori
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter berdasarkan tahun terbit
        if ($request->has('published_year')) {
            $query->where('published_year', $request->input('published_year'));
        }

        // Opsi pengurutan
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            if ($sortBy == 'popularity') {
                $query->withCount('loans')->orderBy('loans_count', 'desc');
            } elseif ($sortBy == 'published_year') {
                $query->orderBy('published_year', 'desc');
            }
        }

        $books = $query->get();
        $categories = Category::all();

        return view('home.catalog', compact('books', 'categories'));
    }
}