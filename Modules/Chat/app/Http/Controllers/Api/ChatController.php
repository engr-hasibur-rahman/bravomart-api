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
use Modules\Chat\app\Transformers\ChatListResource;
use Modules\Chat\app\Transformers\ChatMessageDetailsResource;

class ChatController extends Controller
{

    // Send a message
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        // Check authenticated user
        $authUser = auth()->user();
        if (!$authUser) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized.',
            ], 403);
        }

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


        // sender chat id
        $sender_chat_id = Chat::where('user_id', $authUser->id)->first()->id;
        $data['chat_id'] = $sender_chat_id;

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

        try {
            //  broadcast with Pusher
            event(new \App\Events\MessageSent($message));
        }catch (\Exception $e){}

        return response()->json([
            'success' => true,
            'message_id' => $message->id,
            'message' => 'Message sent Successfully',
        ]);
    }

    public function chatList(Request $request)
    {
        $user_id = auth()->guard('api')->user()->id;
        $chat = Chat::where('user_id',$user_id)
            ->first();

        if (empty($chat)) {
            return response()->json([
                'success' => false,
                'message'  => 'Chats not found',
            ]);
        }

        // chat message get receiver ids
//        $receiver_ids = ChatMessage::where('chat_id', $chat->id)
//            ->where('sender_id', $user_id)
//            ->pluck('receiver_id')
//            ->unique()
//            ->toArray();

        // Get receiver_id + receiver_type from messages
        $receiverData = ChatMessage::where('chat_id', $chat->id)
            ->where('sender_id', $user_id)
            ->get(['receiver_id', 'receiver_type'])
            ->unique(fn ($item) => $item['receiver_id'] . $item['receiver_type'])
            ->values();

        // Build conditions for each unique receiver
        $chats = Chat::with('user')->where(function ($query) use ($receiverData) {
            foreach ($receiverData as $item) {
                $query->orWhere(function ($sub) use ($item) {
                    $sub->where('user_id', $item['receiver_id'])
                        ->where('user_type', $item['receiver_type']);
                });
            }
        });


        // Optional: search filter
        $search = $request->search;
//
//        // find chat with user info
//        $chats =  Chat::with('user')
//            ->whereIn('user_id', $receiver_ids);

        if (isset($request->type) && !empty($request->type)) {
            $chats->where('user_type', $request->type);
        }

        $conversion_user_list =  $chats
            ->orderBy('id', 'asc')
            ->paginate(50);

        return response()->json([
            'success'  => true,
            'data' => ChatListResource::collection($conversion_user_list)
        ]);
    }

    public function chatWiseFetchMessages(Request $request, $receiver_id)
    {

        // Inject route param into validation data
        $data = array_merge($request->all(), ['receiver_id' => $receiver_id]);

        $validator = Validator::make($data, [
            'receiver_id'   => 'required|integer',
            'receiver_type' => 'required|string|in:customer,store,admin,deliveryman',
            'search'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user_id = auth()->guard('api')->user()->id;
        $chat = Chat::where('user_id',$user_id)->first();

        if (empty($chat)) {
            return response()->json([
                'success' => false,
                'message'  => 'Chats not found',
            ]);
        }

        // get message
        $message_query = ChatMessage::where('chat_id', $chat->id)
            ->where('sender_id', $user_id)
            ->where('receiver_id', $receiver_id)
            ->where('receiver_type', $request->receiver_type);

        $unread_message = (clone $message_query)->where('is_seen', 0)->count();
        (clone $message_query)->where('is_seen', 1)->update(['is_seen' => 1]);

        $messages = $message_query
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        return response()->json([
            'success'  => true,
            'unread_message' => $unread_message,
            'data' => ChatMessageDetailsResource::collection($messages)
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
