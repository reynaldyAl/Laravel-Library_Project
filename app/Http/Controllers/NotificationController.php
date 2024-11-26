<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $unreadCount = Notification::where('user_id', Auth::id())->where('read_status', false)->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $notification->update(['read_status' => true]);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->where('read_status', false)->update(['read_status' => true]);

        return response()->json(['success' => true]);
    }

    public function fetchNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())->where('read_status', false)->orderBy('created_at', 'desc')->get();
        $unreadCount = Notification::where('user_id', Auth::id())->where('read_status', false)->count();
        return response()->json(['notifications' => $notifications, 'unreadCount' => $unreadCount]);
    }
}