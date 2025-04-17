<?php

namespace App\Repositories;

use App\Interfaces\ProductQueryManageInterface;
use App\Models\ProductQuery;
use App\Models\Store;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductQueryManageRepository implements ProductQueryManageInterface
{
    public function askQuestion(array $data)
    {
        $customer = auth('api_customer')->user();
        return ProductQuery::create([
            'product_id' => $data['product_id'],
            'customer_id' => $customer->id,
            'question' => $data['question'],
            'store_id' => $data['store_id'],
        ]);
    }

    public function searchQuestion(array $data)
    {
        $query = ProductQuery::with('customer', 'store')
            ->where('product_id', $data['product_id'])
            ->where('status', 1);
        if (!empty($data['search'])) { // Ensure search is not empty
            $query->where(function ($query) use ($data) {
                $query->where('question', 'LIKE', '%' . $data['search'] . '%')
                    ->orWhere('reply', 'LIKE', '%' . $data['search'] . '%');
            });
        }
        return $query->latest()->paginate($data['per_page'] ?? 10);
    }


    public function getSellerQuestions(array $data)
    {
        return ProductQuery::query()
            ->with(['product','customer'])
            ->whereIn('store_id', $data['store_ids'])
            ->when(isset($data['date_filter']), function ($query) use ($data) {
                switch ($data['date_filter']) {
                    case 'last_week':
                        $query->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()]);
                        break;
                    case 'last_month':
                        $query->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]);
                        break;
                    case 'last_year':
                        $query->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()]);
                        break;
                }
            })
            ->when(isset($data['reply_status']), function ($query) use ($data) {
                if ($data['reply_status'] === 'not_replied') {
                    $query->whereNull('replied_at');
                } elseif ($data['reply_status'] === 'replied') {
                    $query->whereNotNull('replied_at')->latest('replied_at');
                }
            })
            ->where('status', 1)
            ->latest()
            ->paginate($data['per_page'] ?? 10);
    }

    public function replyQuestion(array $data)
    {
        $question = ProductQuery::find($data['question_id']);
        if (!$question) {
            return false;
        }
        return $question->update([
            'reply' => $data['reply'],
            'replied_at' => Carbon::now(),
        ]);
    }

    public function getAllQuestionsAndReplies(array $data)
    {
        return ProductQuery::query()
            ->with(['product.related_translations', 'customer', 'store.related_translations'])
            ->when(isset($data['search']), function ($query) use ($data) {
                $searchTerm = $data['search'];

                $query->where(function ($q) use ($searchTerm) {
                    $q->where('product_id', $searchTerm)
                        ->orWhereHas('product', function ($q) use ($searchTerm) {
                            $q->where('name', 'LIKE', '%' . $searchTerm . '%');
                        });
                });

                $query->orWhere(function ($q) use ($searchTerm) {
                    $q->WhereHas('store', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', '%' . $searchTerm . '%');
                    });
                });

                $query->orWhere(function ($q) use ($searchTerm) {
                    $q->where('customer_id', $searchTerm)
                        ->orWhereHas('customer', function ($q) use ($searchTerm) {
                            $q->where('first_name', 'LIKE', '%' . $searchTerm . '%')
                                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%');
                        });
                });
            })
            ->when(isset($data['date_filter']), function ($query) use ($data) {
                switch ($data['date_filter']) {
                    case 'last_week':
                        $query->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()]);
                        break;
                    case 'last_month':
                        $query->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]);
                        break;
                    case 'last_year':
                        $query->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()]);
                        break;
                }
            })
            ->when(isset($data['reply_status']), function ($query) use ($data) {
                if ($data['reply_status'] === 'not_replied') {
                    $query->whereNull('replied_at');
                } elseif ($data['reply_status'] === 'replied') {
                    $query->whereNotNull('replied_at')->latest('replied_at');
                }
            })
            ->when(isset($data['status']), function ($query) use ($data) {
                $query->where('status', $data['status']);
            })
            ->latest()
            ->paginate($data['per_page'] ?? 10);
    }

    public function bulkDelete(array $ids)
    {
        $queries = ProductQuery::whereIn('id', $ids)->get();

        if ($queries->isEmpty()) {
            return false; // Or return an appropriate response
        }
        return ProductQuery::whereIn('id', $ids)->delete();
    }

    public function changeStatus(int $id)
    {
        return ProductQuery::where('id', $id)->exists() &&
            ProductQuery::where('id', $id)->update(['status' => DB::raw('NOT status')]);
    }

}
