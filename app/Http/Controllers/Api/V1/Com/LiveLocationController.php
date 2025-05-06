<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Http\Controllers\Controller;
use App\Models\LiveLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LiveLocationController extends Controller
{
    /**
     * Update or create a live location for a trackable entity.
     */
    public function update(Request $request)
    {
        $request->validate([
            'trackable_type' => 'required|string',  // e.g. App\Models\Deliveryman
            'trackable_id'   => 'required|integer',
            'latitude'       => 'required|numeric|between:-90,90',
            'longitude'      => 'required|numeric|between:-180,180',
            'order_id'       => 'nullable|integer|exists:orders,id',
        ]);

        $location = LiveLocation::updateOrCreate(
            [
                'trackable_type' => $request->trackable_type,
                'trackable_id'   => $request->trackable_id,
            ],
            [
                'latitude'     => $request->latitude,
                'longitude'    => $request->longitude,
                'order_id'     => $request->order_id,
                'last_updated' => Carbon::now(),
            ]
        );

        return response()->json([
            'message'  => __('messages.update_success',['name' => 'Location']),
        ]);
    }
}
