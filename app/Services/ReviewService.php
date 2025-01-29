<?php

namespace App\Services;

use App\Models\Review;

class ReviewService
{
    public function getAllReviews($filters)
    {
        $query = Review::with(['customer', 'reviewable', 'store', 'order']);

        if (isset($filters['customer_name'])) {
            $query->whereHas('customer', function ($customerQuery) use ($filters) {
                $customerQuery->where('first_name', 'like', "%{$filters['customer_name']}%")
                    ->orWhere('last_name', 'like', "%{$filters['customer_name']}%");
            });
        }
        if (isset($filters['reviewable_type'])) {
            $query->where('reviewable_type', $filters['reviewable_type']);
        }

        if (isset($filters['min_rating']) && isset($filters['max_rating'])) {
            $query->whereBetween('rating', [$filters['min_rating'], $filters['max_rating']]);
        } elseif (isset($filters['min_rating'])) {
            $query->where('rating', '>=', $filters['min_rating']);
        } elseif (isset($filters['max_rating'])) {
            $query->where('rating', '<=', $filters['max_rating']);
        } elseif (isset($filters['rating'])) {
            $query->where('rating', $filters['rating']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['store_id'])) {
            $query->where('store_id', $filters['store_id']);
        }
        if (isset($filters['order_id'])) {
            $query->where('order_id', $filters['order_id']);
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }


        // Paginate results
        return $query->latest()->paginate(10);
    }

}
