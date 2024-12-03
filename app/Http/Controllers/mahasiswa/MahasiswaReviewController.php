<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class MahasiswaReviewController extends Controller
{
    public function index()
    {   
        
        if (!Auth::check() || Auth::user()->role->name !== 'mahasiswa') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $reviews = Review::where('user_id', Auth::id())->with('book')->get();
        return view('mahasiswa.reviews.index', compact('reviews'));
    }
}