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

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }
        return $query->latest()->paginate($filters['per_page'] ?? 10);
    }

    public function addReview($data)
    {
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        if ($data['reviewable_type'] == 'delivery_man') {
            $is_deliveryman = User::
        }

        // check reviewable type
        if ($data['reviewable_type'] === 'product') {
            $reviewable_type = 'App\\Models\\Product';
        } elseif ($data['reviewable_type'] === 'delivery_man') {
            $reviewable_type = 'App\\Models\\User';
        } else {
            $reviewable_type = 'undefined';
        }

        // create review
        if (!empty($data)) {
            $review = Review::create([
                "order_id" => $data['order_id'],
                "store_id" => $data['store_id'],
                "reviewable_id" => $data['reviewable_id'],
                "reviewable_type" => $reviewable_type,
                "customer_id" => auth('api_customer')->user()->id,
                "review" => $data['review'],
                "rating" => $data['rating'],
            ]);
            if ($review) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getCustomerReviews($filters)
    {
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }

        $query = Review::with(['reviewable', 'store'])->where('customer_id', auth('api_customer')->user()->id);

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
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }
        return $query->latest()->paginate($filters['per_page'] ?? 10);
    }

}
