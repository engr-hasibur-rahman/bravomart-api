<?php

use Illuminate\Support\Facades\Broadcast;

// Public channel for general order updates
Broadcast::channel('orders', function ($user) {
    return true;  // Everyone can listen to this channel (public channel)
});

// Private channel for a specific order
Broadcast::channel('orders.{orderId}', function ($user, $orderId) {
    // Ensure only the user who owns the order can listen to the channel
    return (int) $user->id === (int) $orderId;  // Allow access only to the user who owns the order
});

// Private channel for a specific user (example)
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;  // Allow access to the channel if the user ID matches
});