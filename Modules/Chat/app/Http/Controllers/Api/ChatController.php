<?php

namespace Modules\Chat\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\PageListResource;
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
        $authUser = auth()->guard('api')->user();
        if (!$authUser) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized.',
            ], 403);
        }

        // if sender type (store) and receiver type (customer or deliveryman) not send message
        if ($authUser->activity_scope === 'store_level' && $request->receiver_type === 'customer') {
            return response()->json([
                'success' => false,
                'message' => 'Store cannot send messages only send to admin.',
            ], 422);
        }

        // receiver info check
        $receiver_id = $request->receiver_id;
        $receiver_type = $request->receiver_type;



        // Get Receiver info
        if ($receiver_type === 'customer') {
            $receiver = Customer::find($receiver_id);
        }elseif($receiver_type === 'store') {
            $receiver = Store::find($receiver_id);
        }elseif(in_array($receiver_type, ['admin', 'store', 'deliveryman'])){
            $receiver = User::find($receiver_id);
        }
        // Check  sender type
        if ($authUser->activity_scope === 'system_level'){
            $authType = 'admin';
        }elseif($authUser->activity_scope === 'store_level'){
            $authType = 'store';
        }elseif($authUser->activity_scope === 'delivery_level'){
            $authType = 'deliveryman';
        }else{
            $authType = 'customer';
        }

        // if receiver exits
        if (empty($receiver)) {
            return response()->json([
                'success' => false,
                'message'  => 'Receiver not found',
            ], 404);
        }

        // Receiver Type Set
        if (!empty($receiver)) {
            if ($receiver->activity_scope === 'system_level'){
                $receiver_type = 'admin';
            }elseif(isset($receiver->store_type) && !empty($receiver->store_type)){
                // store check and store not exits activity_scope check only store_type
                $receiver_type = 'store';
            }elseif($receiver->activity_scope === 'delivery_level'){
                $receiver_type = 'deliveryman';
            }else{
                $receiver_type = 'customer';
            }
        }

       // if sender and receiver type same  message not send
        if ($authType === $receiver_type) {
            return response()->json([
                'success' => true,
                'message' => 'Sender and receiver cannot be of the same type.',
            ]);
        }

        // if sender type (store) and receiver type (customer or deliveryman) not send message
        $sender_type = $authType;
        if ($sender_type === 'store' && $request->receiver_type === 'customer' || $sender_type === 'store' && $request->receiver_type === 'deliveryman') {
            return response()->json([
                'success' => false,
                'message' => 'Store cannot send messages only send to admin.',
            ], 422);
        }


        $data = [
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

    public function customerSendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_type' => 'required|string|in:admin,deliveryman,store',
            'receiver_id' => 'required|integer',
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
        $authUser = auth()->guard('api_customer')->user();
        if (!$authUser) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized.',
            ], 403);
        }

        // if sender type (store) and receiver type (customer or deliveryman) not send message
        if (isset($authUser->activity_scope) && $authUser->activity_scope === 'store_level' && $request->receiver_type === 'customer') {
            return response()->json([
                'success' => false,
                'message' => 'Store cannot send messages only send to admin.',
            ], 422);
        }

        // receiver info check
        $receiver_id = $request->receiver_id;
        $receiver_type = $request->receiver_type;


        // Get Receiver info
        if ($receiver_type === 'customer') {
            $receiver = Customer::find($receiver_id);
        }elseif($receiver_type === 'store') {
            $receiver = Store::find($receiver_id);
        }elseif(in_array($receiver_type, ['admin', 'deliveryman'])){
            if ($receiver_type === 'admin'){
                $receiver = User::where('id', $receiver_id)
                    ->where('activity_scope', 'system_level')
                    ->first();
            }else{
                $receiver = User::where('id', $receiver_id)
                    ->where('activity_scope', 'delivery_level')
                    ->first();
            }
        }

        // Check  sender type
        if ($authUser->activity_scope === 'system_level'){
            $authType = 'admin';
        }elseif($authUser->activity_scope === 'store_level'){
            $authType = 'store';
        }elseif($authUser->activity_scope === 'delivery_level'){
            $authType = 'deliveryman';
        }else{
            $authType = 'customer';
        }

        // if receiver exits
        if (empty($receiver)) {
            return response()->json([
                'success' => false,
                'message'  => 'Receiver not found',
            ], 404);
        }


        // Receiver Type Set
        if (!empty($receiver)) {
            if ($receiver->activity_scope === 'system_level'){
                $receiver_type = 'admin';
            }elseif(isset($receiver->store_type) && !empty($receiver->store_type)){
                // store check and store not exits activity_scope check only store_type
                $receiver_type = 'store';
            }elseif($receiver->activity_scope === 'delivery_level'){
                $receiver_type = 'deliveryman';
            }else{
                $receiver_type = 'customer';
            }
        }

       // if sender and receiver type same  message not send
        if ($authType === $receiver_type) {
            return response()->json([
                'success' => true,
                'message' => 'Sender and receiver cannot be of the same type.',
            ]);
        }

        // if sender type (store) and receiver type (customer or deliveryman) not send message
        $sender_type = $authType;
        if ($sender_type === 'store' && $request->receiver_type === 'customer' || $sender_type === 'store' && $request->receiver_type === 'deliveryman') {
            return response()->json([
                'success' => false,
                'message' => 'Store cannot send messages only send to admin.',
            ], 422);
        }


        $data = [
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

        $auth_user = auth()->guard('api')->user();
        $chat = Chat::where('user_id', $auth_user->id)->first();

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chats not found',
            ]);
        }

        $auth_id = $auth_user->id;
        $auth_type = $auth_user->activity_scope ?? 'admin';

        // admin lists
        if ($auth_type === 'system_level') {
            // get admin sent message chat_ids
            $admin_sent_chat_ids = ChatMessage::where('sender_id', $auth_id)
                ->where('sender_type', 'admin')
                ->pluck('chat_id');
            // get admin received message chat_ids
            $admin_received_chat_ids = ChatMessage::where('receiver_id', $auth_id)
                ->where('receiver_type', 'admin')
                ->pluck('chat_id');
            // Merge both collections and get unique chat_ids
            $all_admin_chat_ids = $admin_sent_chat_ids->merge($admin_received_chat_ids)->unique();
            $all_chat_lists = Chat::with('user')->whereIn('id', $all_admin_chat_ids)->paginate(20);
        }

        // store lists
        if ($auth_type === 'store_level') {
            // get admin sent message chat_ids
            $admin_sent_chat_ids = ChatMessage::where('sender_id', $auth_id)
                ->where('sender_type', 'store')
                ->pluck('chat_id');
            // get admin received message chat_ids
            $admin_received_chat_ids = ChatMessage::where('receiver_id', $auth_id)
                ->where('receiver_type', 'store')
                ->pluck('chat_id');
            // Merge both collections and get unique chat_ids
            $all_admin_chat_ids = $admin_sent_chat_ids->merge($admin_received_chat_ids)->unique();
            $all_chat_lists = Chat::with('user')->whereIn('id', $all_admin_chat_ids)->paginate(20);
        }


        return response()->json([
            'success'  => true,
            'data' => ChatListResource::collection($all_chat_lists)
        ]);
    }

    public function customerChatList(Request $request)
    {

        $auth_user = auth()->guard('api_customer')->user();
        $auth_id = $auth_user->id;
        $auth_type = 'customer';

        $chat = Chat::with(['messages.sender', 'messages.receiver'])
            ->where('user_id', $auth_id)
            ->first();

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chats not found',
            ]);
        }

        $users = collect();

        foreach ($chat->messages as $message) {
            if ($message->sender_id != $auth_id || $message->sender_type != $auth_type) {
                $users->push((object)[
                    'id' => $message->sender_id,
                    'type' => $message->sender_type,
                    'user' => $message->sender
                ]);
            }

            if ($message->receiver_id != $auth_id || $message->receiver_type != $auth_type) {
                $users->push((object)[
                    'id' => $message->receiver_id,
                    'type' => $message->receiver_type,
                    'user' => $message->receiver
                ]);
            }
        }

        $unique_users = $users
            ->unique(fn ($item) => $item->id . '_' . $item->type)
            ->values();

        return response()->json([
            'success'  => true,
            'data' => ChatListResource::collection($unique_users)
        ]);
    }

    public function chatWiseFetchMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            ->where('receiver_id', $request->receiver_id)
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
