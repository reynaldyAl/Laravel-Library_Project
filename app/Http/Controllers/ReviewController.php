<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('home.detail', $book->id)->with('success', 'Review submitted successfully.');
    }

    public function edit(Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            return redirect()->route('home.detail', $review->book_id)->with('error', 'You are not authorized to edit this review.');
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            return redirect()->route('home.detail', $review->book_id)->with('error', 'You are not authorized to update this review.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('home.detail', $review->book_id)->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            return redirect()->route('home.detail', $review->book_id)->with('error', 'You are not authorized to delete this review.');
        }

        $review->delete();

        return redirect()->route('home.detail', $review->book_id)->with('success', 'Review deleted successfully.');
    }
}