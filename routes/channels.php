<?php

use Illuminate\Support\Facades\Broadcast;

// Private channel for a specific customer
Broadcast::channel('customer.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Private channel for a specific seller
Broadcast::channel('seller.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Admin channel – allow access to all authenticated users or restrict by role
Broadcast::channel('admin', function ($user) {
    // Optional: Restrict to users with an admin role
    // return $user->hasRole('admin');
    return true;
});

// (Optional) Default Laravel Echo channel for user presence/auth if needed
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
