<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Notifications\OrderNotificationForAdmin;
use App\Models\Customer;
use App\Models\UniversalNotification;

class NotificationManageController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index()
    {
        // Check if the user is authenticated as an API user or customer
        $user = auth('api')->user();
        $customer = auth('api_customer')->user();

        // If neither user nor customer is authenticated
        if (!$user && !$customer) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401); // 401 Unauthorized
        }

        // Determine the notifiable_type based on user type
        if ($customer) {
            $notifiableType = 'customer';
        } elseif ($user) {
            $notifiableTypes = [
                'system_level' => null,
                'store_level' => 'store',
                'delivery_level' => 'deliveryman',
            ];
            $notifiableType = $notifiableTypes[$user->activity_scope] ?? 'customer';
        }

        // Build the query based on notifiable type
        $query = UniversalNotification::latest();
        if ($notifiableType) {
            $query->where('notifiable_type', $notifiableType);
        }

        // Paginate results
        $notifications = $query->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'List all notifications',
            'data' => OrderNotificationForAdmin::collection($notifications),
            'meta' => new PaginationResource($notifications)
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
