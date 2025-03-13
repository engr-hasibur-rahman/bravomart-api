<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notifications\OrderNotificationForAdmin;
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
            'data' => OrderNotificationForAdmin::collection($notifications)
        ]);
    }


    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        try {
            // Attempt to find the notification
            $notification = UniversalNotification::findOrFail($id);

            // If notification hasn't been read, mark it as read
            if (!$notification->read_at) {
                $notification->update(['read_at' => now()]);
                return response()->json(['message' => 'Notification marked as read']);
            }

            return response()->json(['message' => 'Notification is already marked as read']);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle case where notification is not found
            return response()->json([
                'success' => false,
                'message' => 'Notification not found',
            ], 404);
        }
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
