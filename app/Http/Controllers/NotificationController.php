<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Fetch unread and recent notifications for the logged in user.
     */
    public function index()
    {
        $notifications = Notification::with('course:id,title')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $notifications->where('read_status', false)->count()
        ]);
    }

    /**
     * Mark a notification as read and redirect or return success.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        
        $notification->update(['read_status' => true]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect($notification->link ?? '/dashboard');
    }

    /**
     * Mark all notifications as read for the user.
     */
    public function markAllAsRead(Request $request)
    {
        Notification::where('user_id', Auth::id())
            ->where('read_status', false)
            ->update(['read_status' => true]);

        return response()->json(['success' => true]);
    }
}
