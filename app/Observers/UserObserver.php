<?php

namespace App\Observers;

use App\Models\User;
use Modules\Wallet\app\Models\Wallet;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if ($user->activity_scope === 'store_level'){
            // Create a wallet for the user with initial balance
            Wallet::create([
                'owner_id' => $user->id,
                'owner_type' => User::class,  // Set the polymorphic type
                'balance' => 0,  // Set initial balance
                'status' => 1,   // Set the wallet as active
            ]);
        }

    }

    /**
     * Handle the User "updated" event.
     */

    public function updated(User $user): void
    {

    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
