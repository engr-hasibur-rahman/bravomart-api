<?php

namespace Modules\Chat\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Chat\app\Models\Chat;
use Modules\Chat\app\Models\ChatMessage;

class ChatController extends Controller
{
    // Get or create chat between two parties
    public function startChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|integer|exists:users,id',
            'user_type' => 'required|string|in:customer,store,admin,deliveryman',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $authUser = auth()->user();

        $user_check = Chat::find($authUser->id);

        // check user
        if ($authUser->activity_scope === 'system_level'){
            $authType = 'admin';
        }elseif($authUser->activity_scope === 'store_level'){
            $authType = 'store';
        }elseif($authUser->activity_scope === 'delivery_level'){
            $authType = 'deliveryman';
        }else{
            $authType = 'customer';
        }

        // user chat data create
        if ($user_check) {
            return response()->json([
                'success' => true,
                'message' => 'your already have chat create'
            ]);
        }else{
            $chat = Chat::firstOrCreate([
                'user_id'   => $authUser->id,
                'user_type' => $authType
            ]);
        }

        return response()->json([
            'success' => true,
            'chat_id' => $chat->id,
        ]);
    }

    // Send a message
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|integer|exists:chats,id',
            'receiver_id' => 'required|integer',
            'message' => 'nullable|string',
            'file'   => 'nullable|file|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }


        $authUser = auth()->user();

        // check user
        if ($authUser->activity_scope === 'system_level'){
            $authType = 'admin';
        }elseif($authUser->activity_scope === 'store_level'){
            $authType = 'store';
        }elseif($authUser->activity_scope === 'delivery_level'){
            $authType = 'deliveryman';
        }else{
            $authType = 'customer';
        }

        // receiver type check
        $receiver_id = $request->receiver_id;
        $receiver = User::find($receiver_id);
        if (empty($receiver)) {
            $receiver = Customer::find($receiver_id);
        }

        if (isset($request->receiver_id) && !empty($receiver)) {
            // check user
            if ($receiver->activity_scope === 'system_level'){
                $receiver_type = 'admin';
            }elseif($receiver->activity_scope === 'store_level'){
                $receiver_type = 'store';
            }elseif($receiver->activity_scope === 'delivery_level'){
                $receiver_type = 'deliveryman';
            }else{
                $receiver_type = 'customer';
            }
        }

        $data = [
            'chat_id'      => $request->chat_id,
            'sender_id'    => $authUser->id,
            'sender_type'  => $authType,
            'receiver_id'  => $receiver_id,
            'receiver_type'=> $receiver_type,
            'message'      => $request->message,
        ];

       //

        $message = ChatMessage::create($data);

        // Optionally broadcast with Laravel Echo or Pusher

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    // Fetch messages of a chat
    public function fetchMessages(Request $request, $chatId)
    {
        $messages = ChatMessage::where('chat_id', $chatId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success'  => true,
            'messages' => $messages,
        ]);
    }

    // Mark messages as seen
    public function markAsSeen(Request $request)
    {
        ChatMessage::where('chat_id', $request->chat_id)
            ->where('receiver_id', auth()->id())
            ->where('is_seen', 0)
            ->update(['is_seen' => 1]);

        return response()->json(['success' => true]);
    }
}
