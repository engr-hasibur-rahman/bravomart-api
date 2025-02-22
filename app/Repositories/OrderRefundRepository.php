<?php

namespace App\Repositories;

use App\Interfaces\OrderRefundInterface;
use App\Models\Order;
use App\Models\OrderMaster;
use App\Models\OrderRefund;
use App\Models\OrderRefundReason;
use App\Models\Translation;
use Illuminate\Http\Request;

class OrderRefundRepository implements OrderRefundInterface
{
    public function __construct(protected OrderRefundReason $refundReason, protected Translation $translation)
    {

    }

    public function translationKeys(): mixed
    {
        return $this->refundReason->translationKeys;
    }

    /* -------------------------------------------------------->Order Refund<--------------------------------------------------- */
    public function get_order_refund_request(array $filters)
    {
        $query = OrderRefund::query();
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['search'])) {
            $query->whereHas('customer', function ($query) use ($filters) {
                $query->where('first_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('last_name', 'like', '%' . $filters['search'] . '%');
            });
        }
        if (isset($filters['search'])) {

        }
    }

    public function create_order_refund_request(int $order_id, array $data)
    {
        if (!$order_id) {
            return false;
        }
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        $customer = auth('api_customer')->user();
        $order = Order::find($order_id);
        $order_belongs_to_customer = OrderMaster::where('id', $order->order_master_id)->where('customer_id', $customer->id)->exists();
        if (!$order_belongs_to_customer) {
            return 'does_not_belong_to_customer';
        }
        if ($order->status === 'delivered' || $order->delivery_completed_at !== null) {
            return 'already_delivered';
        }
        if ($order->status === 'cancelled' || $order->cancelled_at !== null) {
            return 'already_cancelled';
        }
        $alreadyRequested = OrderRefund::where('order_id', $order_id)->exists();
        if ($alreadyRequested) {
            return 'already_requested_for_refund';
        }
        $success = OrderRefund::create([
            'order_id' => $order_id,
            'customer_id' => $customer->id,
            'store_id' => $order->store_id,
            'order_refund_reason_id' => $data['order_refund_reason_id'],
            'customer_note' => $data['customer_note'],
            'file' => $data['file'],
            'status' => 'pending',
            'amount' => $order->order_amount,
        ]);
        if ($success) {
            $order->refund_status = 'requested';
            $order->save();
            return true;
        } else {
            return false;
        }
    }

    /* -------------------------------------------------------->Refund Reason<--------------------------------------------------- */

    public function order_refund_list(array $filters)
    {
        $query = OrderRefundReason::query();
        if (isset($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('reason', 'LIKE', $searchTerm)
                    ->orWhereHas('related_translations', function ($q) use ($searchTerm) {
                        $q->whereIn('key', ['reason'])
                            ->where('value', 'LIKE', $searchTerm);
                    });
            });
        }
        $perPage = $filters['per_page'] ?? 10;
        return $query->with('related_translations')->paginate($perPage);
    }

    public function create_order_refund_reason(string $reason)
    {
        if ($reason) {
            $reason = OrderRefundReason::create([
                'reason' => $reason
            ]);
            return $reason->id;
        } else {
            return false;
        }
    }

    public function update_order_refund_reason(array $data)
    {
        $reason = OrderRefundReason::find($data['id']);
        if ($reason) {
            $reason->update([
                'reason' => $data['reason']
            ]);
            return $reason->id;
        } else {
            return false;
        }
    }

    public function get_order_refund_reason_by_id(int $id)
    {
        $reason = OrderRefundReason::with('related_translations')->find($id);
        if (!$reason) {
            return false;
        }
        return $reason;
    }


    public function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        if (empty($request['translations'])) {
            return false;  // Return false if no translations are provided
        }

        $translations = [];
        foreach ($request['translations'] as $translation) {
            foreach ($colNames as $key) {
                // Fallback value if translation key does not exist
                $translatedValue = $translation[$key] ?? null;

                // Skip translation if the value is NULL
                if ($translatedValue === null) {
                    continue; // Skip this field if it's NULL
                }

                // Check if a translation exists for the given reference path, ID, language, and key
                $trans = $this->translation
                    ->where('translatable_type', $refPath)
                    ->where('translatable_id', $refid)
                    ->where('language', $translation['language_code'])
                    ->where('key', $key)
                    ->first();

                if ($trans) {
                    // Update the existing translation
                    $trans->value = $translatedValue;
                    $trans->save();
                } else {
                    // Prepare new translation entry for insertion
                    $translations[] = [
                        'translatable_type' => $refPath,
                        'translatable_id' => $refid,
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }

        // Insert new translations if any
        if (!empty($translations)) {
            $this->translation->insert($translations);
        }

        return true;
    }

    public function delete_order_refund_reason(int $id)
    {
        $reason = OrderRefundReason::find($id);
        if ($reason) {
            // Delete related translations
            $this->translation->where('translatable_type', OrderRefundReason::class)
                ->where('translatable_id', $id)
                ->delete();

            // Delete the refund reason
            $reason->delete();

            return true;
        } else {
            return false;
        }
    }
}