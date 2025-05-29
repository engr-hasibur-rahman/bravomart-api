<?php

namespace Modules\Chat\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
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
            'receiver_type' => 'required|string|in:customer,store,admin,deliveryman',
            'message' => 'nullable|string',
            'file'   => 'nullable|file|mimes:png,jpg,jpeg,webp,gif,pdf|max:2048', // max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }


        $authUser = auth()->user();

        // receiver type check
        $receiver_id = $request->receiver_id;

        // check user
        if ($authUser->activity_scope === 'system_level'){
            $authType = 'admin';
        }elseif(isset($receiver->store_type) && !empty($receiver->store_type)){
            $authType = 'store';
        }elseif($authUser->activity_scope === 'delivery_level'){
            $authType = 'deliveryman';
        }else{
            $authType = 'customer';
        }

        if ($request->receiver_type === 'customer') {
            $receiver = Customer::find($receiver_id);
        }elseif($request->receiver_type === 'store') {
            $receiver = Store::find($receiver_id);
        }elseif(in_array($request->receiver_type, ['admin', 'store', 'deliveryman'])){
            $receiver = User::find($receiver_id);
        }

        // if receiver exits
        if (empty($receiver)) {
            return response()->json([
                'success' => false,
                'message'  => 'Receiver not found',
            ], 404);
        }


        if (isset($request->receiver_id) && !empty($receiver)) {
            // check user
            if ($receiver->activity_scope === 'system_level'){
                $receiver_type = 'admin';
            }elseif(isset($receiver->store_type) && !empty($receiver->store_type)){
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
            'receiver_id'  => $receiver->id,
            'receiver_type'=> $receiver_type,
            'message'      => $request->message,
        ];


        // upload file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . Str::random(10) . '.' . $extension;
            $uploadPath = 'uploads/chat/' . $filename;
            $fullPath = storage_path('app/public/' . $uploadPath);

            // Image files
            if (in_array($extension, ['png', 'jpg', 'jpeg', 'webp', 'gif'])) {
                $image = Image::make($file)->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $image->save($fullPath);
            }
            // PDF or other allowed non-image
            elseif ($extension === 'pdf') {
                $file->storeAs('uploads/chat', $filename, 'public');
            }

            $data['file'] = $uploadPath;
        }

        $message = ChatMessage::create($data);

        // Optionally broadcast with Laravel Echo or Pusher
        event(new \App\Events\MessageSent($message));
        \Log::info('Broadcasting message', ['message_id' => $message->id]);
        return response()->json([
            'success' => true,
            'message_id' => $message->id,
            'message' => 'Message sent Successfully',
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
