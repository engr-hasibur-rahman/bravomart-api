<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\UniversalNotification;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index()
    {
        $notifications = UniversalNotification::latest()->paginate(50);

        if (count($notifications) == 0) {
            return response()->json([
                'success' => true,
                'message' => 'No notifications found',
                'data' => []
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'List all notifications',
            'data' => $notifications
        ]);
    }


    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = UniversalNotification::findOrFail($id);
        $notification->update(['read_at' => now()]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    /**
     * Remove the specified notification.
     */
    public function destroy($id)
    {
        $notification = UniversalNotification::findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully']);
    }

}
