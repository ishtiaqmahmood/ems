<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function unread()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'data' => $notification->data,
                'created_at_human' => $notification->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $user->unreadNotifications->count(),
        ]);
    }

    public function markAsRead($id)
    {
        Auth::user()->unreadNotifications->where('id', $id)->markAsRead();
        return response()->json(['success' => true]);
    }
}
