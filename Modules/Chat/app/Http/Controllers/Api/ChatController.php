<?php

namespace Modules\Chat\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Chat\app\Models\Chat;
use Modules\Chat\app\Models\ChatMessage;

class ChatController extends Controller
{
    // Get or create chat between two parties
    public function startChat(Request $request)
    {
       $validator =   Validator::make($request->all(), [
            'user_id'     => 'required|integer',
            'user_type'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }

        $authUser = auth()->user();
        $authType = class_basename($authUser);

        $chat = Chat::firstOrCreate([
            'user_id'   => $authUser->id,
            'user_type' => $authType,
            'with_id'   => $request->user_id,
            'with_type' => $request->user_type,
        ]);

        return response()->json([
            'success' => true,
            'chat_id' => $chat->id,
        ]);
    }

    // Send a message
    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_id'       => 'required|integer|exists:chats,id',
            'message'       => 'nullable|string',
            'file'          => 'nullable|file|max:2048',
        ]);

        $authUser = auth()->user();
        $authType = class_basename($authUser);

        $data = [
            'chat_id'      => $request->chat_id,
            'sender_id'    => $authUser->id,
            'sender_type'  => $authType,
            'receiver_id'  => $request->receiver_id,
            'receiver_type'=> $request->receiver_type,
            'message'      => $request->message,
        ];

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('chat_files', 'public');
        }

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
