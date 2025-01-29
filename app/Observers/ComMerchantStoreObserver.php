<?php

namespace App\Observers;

use App\Models\ComMerchantStore;
use Modules\Wallet\app\Models\Wallet;

class ComMerchantStoreObserver
{
    /**
     * Handle the Store "created" event.
     */
    public function created(ComMerchantStore $store): void
    {
        // Create a wallet for the customer with initial balance
        Wallet::create([
            'owner_id' => $store->id,
            'owner_type' => ComMerchantStore::class,  // Set the polymorphic type
            'balance' => 0,  // Set initial balance
            'status' => 1,   // Set the wallet as active
        ]);
    }


}
