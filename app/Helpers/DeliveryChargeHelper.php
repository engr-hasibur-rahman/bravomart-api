<?php

namespace App\Helpers;

use App\Models\StoreArea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class DeliveryChargeHelper
{

    public static function calculateDeliveryCharge($areaId, $customerLat, $customerLng)
    {

        // Get the store area and settings
        $store_area = StoreArea::with('storeTypeSettings')->find($areaId);

        // If not found, try to find the nearest store area based on latitude & longitude
        if (!$store_area) {
            $store_area = StoreArea::with('storeTypeSettings')->selectRaw(
                "*, ST_Distance_Sphere(point(center_longitude, center_latitude), point(?, ?)) as distance",
                [$customerLng, $customerLat]
            )
                ->whereNotNull('center_latitude')
                ->whereNotNull('center_longitude')
                ->where('status', 1)
                ->orderBy('distance')
                ->first();
            if (!$store_area) {
                return response()->json([
                    'message' => 'Both area_id and center latitude and center longitude are not available'
                ], 404)->original;
            }
            if ($store_area->storeTypeSettings->isEmpty()) {
                $settings = DB::table('store_area_settings')
                    ->where('store_area_id', $store_area->id)
                    ->first();

                if (!$settings) {
                    return response()->json([
                        'message' => 'No settings found for the store area.'
                    ], 404)->original;
                }
            }
        }
        // for test Optionally update coordinates if needed
        //    self::updateStoreAreaCoordinates($areaId);
        $settings = $store_area->storeTypeSettings->first();
        $store_lat = $store_area->center_latitude;
        $store_lng = $store_area->center_longitude;

        // Calculate distance using Haversine formula
        $distance = DB::select("
        SELECT ST_Distance_Sphere(
            point(?, ?),
            point(?, ?)
        ) / 1000 as distance
    ", [$store_lng, $store_lat, $customerLng, $customerLat])[0]->distance;

        $distance = max(1, round($distance, 2)); // Ensure at least 1km and rounding to 2 decimal points

        // Check if customer is inside the area
        // $is_out_of_area = DB::table('store_areas')
        //     ->select(DB::raw('ST_Contains(coordinates, ST_GeomFromText(?)) AS is_inside'))
        //     ->where('id', $areaId)
        //     ->addBinding("POINT({$customerLng} {$customerLat})", 'select')
        //     ->first()
        //     ->is_inside;

        // new add
        $is_out_of_area = DB::table('store_areas')
            ->select(DB::raw('ST_Contains(coordinates, ST_GeomFromText(?)) AS is_inside'))
            ->where('id', $areaId)
            ->addBinding("POINT({$customerLng} {$customerLat})", 'select')
            ->first();

        // new add  Ensure the query result is not null before accessing 'is_inside'
        $is_inside_area = $is_out_of_area ? (bool)$is_out_of_area->is_inside : false;

        // If the customer is out of area, add out-of-area charge
        $out_of_area_delivery_charge = $is_out_of_area ? 0 : $settings->out_of_area_delivery_charge;
        $out_of_area_delivery_info = $is_out_of_area ? 'in area' : 'out of area';


        // Initialize delivery charge
        $delivery_charge = 0;
        $remaining_distance = $distance;

        $storeAreaSetting = $store_area->storeTypeSettings->first();

        if ($settings->delivery_charge_method === 'fixed') {
            $delivery_charge = $settings->fixed_charge_amount;
        } elseif ($settings->delivery_charge_method === 'per_km') {
            $delivery_charge = $settings->per_km_charge_amount * $distance;
        } elseif ($settings->delivery_charge_method === 'range-wise') {
            // Get the slabs for this store area
            $slabs = DB::table('store_area_setting_range_charges')
                ->where('store_area_setting_id', $storeAreaSetting->id)
                ->orderBy('min_km', 'asc') // Ensure slabs are in order
                ->get();

            // Loop through the slabs and calculate the charge
            foreach ($slabs as $slab) {
                $slab_min = $slab->min_km;
                $slab_max = $slab->max_km;
                $slab_rate = $slab->charge_amount;


                // Check if there is remaining distance in the current slab range
                if ($remaining_distance <= 0) {
                    break; // No remaining distance, stop the loop
                }

                if ($remaining_distance > $slab_max) {
                    // If the remaining distance is greater than the slab's max, apply the full slab rate
                    $distance_in_this_slab = $slab_max - $slab_min;
                    $delivery_charge += $distance_in_this_slab * $slab_rate;
                    $remaining_distance -= $distance_in_this_slab;

                } elseif ($remaining_distance > $slab_min) {
                    // If the remaining distance fits within the current slab
                    $distance_in_this_slab = $remaining_distance - $slab_min;
                    $delivery_charge += $distance_in_this_slab * $slab_rate;
                    $remaining_distance = 0; // No remaining distance to calculate
                }
            }

            // If there is still remaining distance, apply it to the last slab's rate
            if ($remaining_distance > 0) {
                // Get the last slab
                $last_slab = $slabs->last();
                $delivery_charge += $remaining_distance * $last_slab->charge_amount;
            }
        }


        // Add out-of-area charge if applicable
        $delivery_charge += $out_of_area_delivery_charge;

        // Ensure minimum delivery fee
        $delivery_charge = max($settings->min_order_delivery_fee, $delivery_charge);

        return [
            'message' => 'Calculation successful',
            'delivery_method' => $settings->delivery_charge_method,
            'delivery_charge' => round($delivery_charge, 2),
            'distance_km' => round($distance, 2),
            'info' => $out_of_area_delivery_info,
        ];
    }


    public static function updateStoreAreaCoordinates(int $areaId)
    {
        // Define Dhaka Division coordinates as a Polygon
        $dhaka_division_coordinates = new Polygon([
            new LineString([
                new Point(24.0340, 89.7936), // North-West
                new Point(24.2524, 90.7876), // North-East
                new Point(23.5310, 90.7050), // Center
                new Point(23.0500, 90.0000), // South-East
                new Point(23.6448, 89.2184), // South-West
                new Point(24.0340, 89.7936)  // Closing the polygon
            ])
        ]);

        // Define center latitude & longitude for Dhaka Division
        $dhaka_center_latitude = 23.8103;
        $dhaka_center_longitude = 90.4125;

        // Fetch the store area by its ID
        $store_area = StoreArea::with('storeTypeSettings')->find($areaId);

        // Ensure the store area exists before updating
        if ($store_area) {
            $store_area->update([
                'coordinates' => $dhaka_division_coordinates,
                'center_latitude' => $dhaka_center_latitude,
                'center_longitude' => $dhaka_center_longitude,
            ]);
        } else {
            // Handle the case if store area is not found (optional)
            dd("Store area not found with ID {$areaId}");
        }
    }




//    public static function calculateDeliveryCharge($areaId, $customerLat, $customerLng)
//    {
//
//        // Define Dhaka Division coordinates as a Polygon
//        $dhaka_division_coordinates = new Polygon([
//            new LineString([
//                new Point(24.0340, 89.7936), // North-West
//                new Point(24.2524, 90.7876), // North-East
//                new Point(23.5310, 90.7050), // Center
//                new Point(23.0500, 90.0000), // South-East
//                new Point(23.6448, 89.2184), // South-West
//                new Point(24.0340, 89.7936)  // Closing the polygon
//            ])
//        ]);
//
//        // Define center latitude & longitude for Dhaka Division
//        $dhaka_center_latitude = 23.8103;
//        $dhaka_center_longitude = 90.4125;
//
//        $store_area = StoreArea::with('storeTypeSettings')->find($areaId);
//
//        // Check if the store area exists before updating
//        $store_area->update([
//            'coordinates' => $dhaka_division_coordinates,
//            'center_latitude' => $dhaka_center_latitude,
//            'center_longitude' => $dhaka_center_longitude,
//        ]);
//
//
//        if (!$store_area || !$store_area->storeTypeSettings) {
//            return false;
//        }
//
//        $settings = $store_area->storeTypeSettings->first();
//        $store_lat = $store_area->center_latitude;
//        $store_lng = $store_area->center_longitude;
//
//        // Calculate distance using Haversine formula
//        $distance = DB::select("
//            SELECT ST_Distance_Sphere(
//                point(?, ?),
//                point(?, ?)
//            ) / 1000 as distance
//        ", [$store_lng, $store_lat, $customerLng, $customerLat])[0]->distance;
//
//
//        $distance = max(1, $distance); // Ensure at least 1km
//
//        // Calculate delivery charge
//        $delivery_charge = 0;
//
//        // Check if customer is outside the store's area using spatial check
//        $is_out_of_area = DB::table('store_areas')
//            ->select(DB::raw('ST_Contains(coordinates, ST_GeomFromText(?)) AS is_inside'))
//            ->where('id', $areaId)
//            ->addBinding("POINT({$customerLng} {$customerLat})", 'select')
//            ->first()
//            ->is_inside;
//
//
//        // If the customer is out of area
//        $out_of_area_delivery_charge = 0;
//        if (!$is_out_of_area) {
//            // If the customer is out of area, check if `out_of_area_delivery_charge` is applicable
//            $out_of_area_delivery_charge = $settings->out_of_area_delivery_charge;
//        }
//
//        if ($settings->delivery_charge_method === 'fixed') {
//            $delivery_charge = $settings->fixed_charge_amount;
//        } elseif ($settings->delivery_charge_method === 'per_km') {
//            $delivery_charge = $settings->per_km_charge_amount * $distance;
//        } elseif ($settings->delivery_charge_method === 'range-wise'){
//            // Get the range-wise charge based on distance
//            $range_charge = DB::table('store_area_setting_range_charges')
//                ->where('store_area_id', $areaId)
//                ->where('min_km', '<=', $distance)
//                ->where('max_km', '>=', $distance)
//                ->first();
//
//            $delivery_charge = ($range_charge->charge_amount * round($distance, 2)) + $out_of_area_delivery_charge;
//        }
//
//
//        // If the customer is out of the area, add `out_of_area_delivery_charge`
//        dd('Total km:' .  ' ' . round($distance, 2), 'per km range:' . $range_charge->charge_amount,'out of area charge sum + :' . $out_of_area_delivery_charge, 'delivery charge:' . $delivery_charge);
//        if (!$is_out_of_area) {
//            $delivery_charge += $out_of_area_delivery_charge;
//        }
//
////        dd($delivery_charge);
//
//        // minimum delivery fee check and add
//        $delivery_charge = max($settings->min_order_delivery_fee, $delivery_charge);
//
//        return [
//            'delivery_method' => $settings->delivery_charge_method,
//            'delivery_charge' => round($delivery_charge, 2),
//            'distance_km' => round($distance, 2),
//        ];
//    }

}
