<?php

namespace App\Helpers;

use App\Models\StoreArea;
use Illuminate\Support\Facades\DB;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class DeliveryChargeHelper
{
    public static function calculateDeliveryCharge($areaId, $customerLat, $customerLng)
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

        $store_area = StoreArea::with('storeTypeSettings')->find($areaId);

        // Check if the store area exists before updating
        $store_area->update([
            'coordinates' => $dhaka_division_coordinates,
            'center_latitude' => $dhaka_center_latitude,
            'center_longitude' => $dhaka_center_longitude,
        ]);


        if (!$store_area || !$store_area->storeTypeSettings) {
            return false;
        }

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


        $distance = max(1, $distance); // Ensure at least 1km

        // Calculate delivery charge
        $delivery_charge = 0;

        // Check if customer is outside the store's area using spatial check
        $is_out_of_area = DB::table('store_areas')
            ->select(DB::raw('ST_Contains(coordinates, ST_GeomFromText(?)) AS is_inside'))
            ->where('id', $areaId)
            ->addBinding("POINT({$customerLng} {$customerLat})", 'select')
            ->first()
            ->is_inside;


        // If the customer is out of area
        if (!$is_out_of_area) {
            // If the customer is out of area, check if `out_of_area_delivery_charge` is applicable
            $delivery_charge = $settings->out_of_area_delivery_charge;
        }else{
            if ($settings->delivery_charge_method === 'fixed') {
                $delivery_charge = $settings->fixed_charge_amount;
            } elseif ($settings->delivery_charge_method === 'per_km') {
                $delivery_charge = $settings->per_km_charge_amount * $distance;
            }
        }

        dd($delivery_charge, $delivery_charge);


        // Ensure minimum delivery fee
        $delivery_charge = max($settings->min_order_delivery_fee, $delivery_charge);


        return [
            'delivery_method' => $settings->delivery_charge_method,
            'delivery_charge' => round($delivery_charge, 2),
            'distance_km' => round($distance, 2),
        ];
    }

}
