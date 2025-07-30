<?php

namespace Modules\Chat\app\Http\Controllers\Api;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Chat\app\Models\Chat;
use Modules\Chat\app\Models\ChatMessage;
use Modules\Chat\app\Transformers\ChatListResource;
use Modules\Chat\app\Transformers\ChatMessageDetailsResource;

class AdminChatController extends Controller
{
    public function adminChatList(Request $request)
    {
        $auth_user = auth()->guard('api')->user();

        $chat = Chat::where('user_id', $auth_user->id)
            ->where('user_type', 'admin')
            ->first();

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => __('chat::messages.not_found', ['name' => 'Chat']),
            ]);
        }

        $query = Chat::with('user')
            ->where('user_type', '!=', 'admin')
            ->withLiveChatEnabledStoreSubscription();

        // Filter by user_type
        $type = $request->input('type');
        if (!empty($type) && $type !== 'all') {
            $query->where('user_type', $type);
        }

        // Filter by name
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->when(true, function ($q2) use ($search) {
                    // Customer
                    $q2->orWhere(function ($q3) use ($search) {
                        $q3->where('user_type', 'customer')
                            ->whereHasMorph('user', ['customer'], function ($q4) use ($search) {
                                $q4->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%");
                            });
                    });

                    // Deliveryman
                    $q2->orWhere(function ($q3) use ($search) {
                        $q3->where('user_type', 'deliveryman')
                            ->whereHasMorph('user', ['deliveryman'], function ($q4) use ($search) {
                                $q4->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%");
                            });
                    });

                    // Store
                    $q2->orWhere(function ($q3) use ($search) {
                        $q3->where('user_type', 'store')
                            ->whereHasMorph('user', ['store'], function ($q4) use ($search) {
                                $q4->where('name', 'like', "%{$search}%");
                            });
                    });
                });
            });
        }

        $chats = $query->paginate($request->input('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => ChatListResource::collection($chats),
            'meta' => new PaginationResource($chats)
        ]);
    }


    public function chatWiseFetchMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|integer',
            'receiver_type' => 'required|string|in:customer,store,admin,deliveryman',
            'search' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $auth_id = auth()->guard('api')->user()->id;
        $chat = Chat::where('user_id', $auth_id)->first();

        if (empty($chat)) {
            return response()->json([
                'success' => false,
                'message' => __('chat::messages.not_found', ['name' => 'Chat']),
            ]);
        }


        $auth_type = 'admin';

        $receiver_id = $request->receiver_id;
        $receiver_type = $request->receiver_type;

        if ($receiver_type == 'store') {
            $isLiveChatEnabled = checkSubscription($receiver_id, 'live_chat');
            if (!$isLiveChatEnabled) {
                return response()->json([
                    'message' => __('chat::messages.feature_not_available', ['name' => 'Chat']),
                ], 422);
            }
        }

        // get message
        $message_query = ChatMessage::query()
            ->where(function ($query) use ($auth_id, $auth_type, $receiver_id, $receiver_type) {
                $query->where(function ($q) use ($auth_id, $auth_type, $receiver_id, $receiver_type) {
                    $q->where('sender_id', $auth_id)
                        ->where('sender_type', $auth_type)
                        ->where('receiver_id', $receiver_id)
                        ->where('receiver_type', $receiver_type);
                })->orWhere(function ($q) use ($auth_id, $auth_type, $receiver_id, $receiver_type) {
                    $q->where('sender_id', $receiver_id)
                        ->where('sender_type', $receiver_type)
                        ->where('receiver_id', $auth_id)
                        ->where('receiver_type', $auth_type);
                });
            });

        $unread_message = (clone $message_query)->where('is_seen', 0)->count();
        (clone $message_query)->where('is_seen', 1)->update(['is_seen' => 1]);

        $messages = $message_query
            ->latest()
            ->paginate(30);

        return response()->json([
            'success' => true,
            'unread_message' => $unread_message,
            'data' => ChatMessageDetailsResource::collection($messages),
            'meta' => new PaginationResource($messages)
        ]);
    }

    public function markAsSeen(Request $request)
    {
        ChatMessage::where('chat_id', $request->chat_id)
            ->where('receiver_id', auth()->id())
            ->where('is_seen', 0)
            ->update(['is_seen' => 1]);

        return response()->json(['success' => true]);
    }
}
