<?php
// app/Http/Controllers/mahasiswa/MahasiswaBookController.php
namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaBookController extends Controller
{
    public function index()
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'mahasiswa') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $books = Book::with(['category', 'reviews', 'loans'])->get();
        foreach ($books as $book) {
            $book->average_rating = $book->reviews->avg('rating');
            $book->loan_count = $book->loans->count();
            $book->popularity = $book->average_rating * 0.7 + $book->loan_count * 0.3;
        }
        $books = $books->sortByDesc('popularity');
        return view('mahasiswa.books.index', compact('books'));
    }

    public function show(Book $book)
    {   
        
        if (!Auth::check() || Auth::user()->role->name !== 'mahasiswa') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $book->load(['category', 'reviews', 'loans']);
        $book->average_rating = $book->reviews->avg('rating');
        $book->loan_count = $book->loans->count();
        $book->popularity = $book->average_rating * 0.7 + $book->loan_count * 0.3;

        return view('mahasiswa.books.show', compact('book'));
    }
}