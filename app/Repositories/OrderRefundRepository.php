<?php

namespace App\Repositories;

use App\Interfaces\OrderRefundInterface;
use App\Models\Order;
use App\Models\OrderMaster;
use App\Models\OrderRefund;
use App\Models\OrderRefundReason;
use App\Models\Store;
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
        if (isset($filters['order_refund_reason_id'])) {
            $query->where('order_refund_reason_id', $filters['order_refund_reason_id']);
        }
        if (isset($filters['store_id'])) {
            $query->where('store_id', $filters['store_id']);
        }
        return $query->with(['store.related_translations', 'customer', 'orderRefundReason.related_translations'])->latest()->paginate($filters['per_page'] ?? 10);
    }

    public function get_seller_store_order_refund_request(int $store_id, array $filters)
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
        if (isset($filters['order_refund_reason_id'])) {
            $query->where('order_refund_reason_id', $filters['order_refund_reason_id']);
        }

        return $query->where('store_id', $store_id)
            ->with(['store', 'customer', 'orderRefundReason'])
            ->paginate($filters['per_page'] ?? 10);
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
        if ($order->status !== 'delivered') {
            return 'not_delivered';
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
            'file' => $data['file'] ?? null,
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

    public function approve_refund_request(int $id, string $status)
    {
        $request = OrderRefund::find($id);

        if (!$request) {
            return false;
        }

        $request->update(['status' => $status]);

        return (bool)Order::where('id', $request->order_id)
            ->update(['refund_status' => 'processing']);
    }

    public function reject_refund_request(int $id, string $status, string $reason)
    {
        $request = OrderRefund::find($id);

        if (!$request) {
            return false;
        }

        $request->update([
            'status' => $status,
            'reject_reason' => $reason
        ]);

        return (bool)Order::where('id', $request->order_id)
            ->update(['refund_status' => 'rejected']);
    }

    public function refunded_refund_request(int $id, string $status)
    {
        $request = OrderRefund::find($id);

        if (!$request) {
            return false;
        }

        $request->update(['status' => $status]);

        return (bool)Order::where('id', $request->order_id)
            ->update(['refund_status' => 'refunded']);
    }

    /* -------------------------------------------------------->Refund Reason<--------------------------------------------------- */

    public function order_refund_reason_list(array $filters)
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
            return false;
        }

        $requestedLanguages = array_column($request['translations'], 'language_code');

        // Delete translations for languages not present in the request
        $this->translation->where('translatable_type', $refPath)
            ->where('translatable_id', $refid)
            ->whereNotIn('language', $requestedLanguages)
            ->delete();

        $translations = [];
        foreach ($request['translations'] as $translation) {
            foreach ($colNames as $key) {
                $translatedValue = $translation[$key] ?? null;

                if ($translatedValue === null) {
                    continue;
                }

                $trans = $this->translation
                    ->where('translatable_type', $refPath)
                    ->where('translatable_id', $refid)
                    ->where('language', $translation['language_code'])
                    ->where('key', $key)
                    ->first();

                if ($trans) {
                    $trans->value = $translatedValue;
                    $trans->save();
                } else {
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