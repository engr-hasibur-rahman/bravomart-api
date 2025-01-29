<?php

namespace App\Services;

use App\Models\Review;

class ReviewService
{
    public function getAllReviews($filters)
    {
        $query = Review::with(['customer', 'reviewable', 'store', 'order']);

        // 1️⃣ Filter by Customer Name
        if (isset($filters['customer_name'])) {
            $query->whereHas('customer', function ($customerQuery) use ($filters) {
                $customerQuery->where('first_name', 'like', "%{$filters['customer_name']}%")
                    ->orWhere('last_name', 'like', "%{$filters['customer_name']}%");
            });
        }

        // 2️⃣ Filter by Product or Deliveryman Name (Polymorphic Relationship)
        if (isset($filters['reviewable_name'])) {
            $query->whereHas('reviewable', function ($reviewableQuery) use ($filters) {
                $reviewableQuery->where('name', 'like', "%{$filters['reviewable_name']}%");
            });
        }

        // 3️⃣ Filter by Rating (1-5)
        if (isset($filters['rating'])) {
            $query->where('rating', $filters['rating']);
        }

        // 4️⃣ Filter by Status (pending, approved, rejected)
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // 5️⃣ Filter by Store ID
        if (isset($filters['store_id'])) {
            $query->where('store_id', $filters['store_id']);
        }

        // 6️⃣ Filter by Order ID
        if (isset($filters['order_id'])) {
            $query->where('order_id', $filters['order_id']);
        }

        // 7️⃣ Filter by Date Range
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        // 8️⃣ Filter by Like or Dislike Count
        if (isset($filters['min_likes'])) {
            $query->where('like_count', '>=', $filters['min_likes']);
        }
        if (isset($filters['min_dislikes'])) {
            $query->where('dislike_count', '>=', $filters['min_dislikes']);
        }

        // Paginate results
        return $query->latest()->paginate(10);
    }

}
