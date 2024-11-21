<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class MahasiswaReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())->with('book')->get();
        return view('mahasiswa.reviews.index', compact('reviews'));
    }
}