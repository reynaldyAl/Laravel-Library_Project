<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::find($request->id);
        if ($notification && $notification->user_id == Auth::id()) {
            $notification->update(['read_status' => true]);
        }
        return response()->json(['success' => true]);
    }
}