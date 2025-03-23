<?php

namespace App\Repositories;

use App\Interfaces\SubscriberManageInterface;
use App\Mail\SubscribedMail;
use App\Mail\UnsubscribedMail;
use App\Models\Subscriber;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SubscriberManageRepository implements SubscriberManageInterface
{
    public function __construct(protected Subscriber $subscriber)
    {

    }

    public function subscribe(array $data)
    {
        $subscriber = Subscriber::updateOrCreate(
            ['email' => $data['email']],
            [
                'is_subscribed' => true,
                'unsubscribed_at' => null,
            ]
        );

        // Send custom subscription mail
        Mail::to($subscriber->email)->send(new SubscribedMail($subscriber));

        return $subscriber;
    }

    public function unsubscribe(string $email)
    {
        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber && $subscriber->is_subscribed) {
            $subscriber->update([
                'is_subscribed' => false,
                'unsubscribed_at' => Carbon::now(),
            ]);

            // Send custom unsubscription mail
            Mail::to($subscriber->email)->send(new UnsubscribedMail($subscriber));

            return $subscriber;
        }

        return null;
    }

    public function getSubscribers(array $filters)
    {
        $subscribers = Subscriber::query();

        if (isset($filters['status'])) {
            $subscribers->where('is_subscribed', $filters['status']);
        }
        if (isset($filters['created_at'])) {
            $subscribers->where('created_at', $filters['subscribed_at']);
        }

        if (isset($filters['email'])) {
            $subscribers->where('email', 'like', "%{$filters['email']}%");
        }

        $subscribersList = $subscribers->orderBy('created_at', $filters['sortOrder'] ?? 'desc')->paginate($filters['perPage'] ?? 10);

        return $subscribersList;
    }

    public function changeStatus(array $data)
    {
        // Retrieve subscribers whose current status doesn't match the requested status
        $subscribersToUpdate = Subscriber::whereIn('id', $data['ids'])
            ->where('is_subscribed', '!=', $data['status'])
            ->get();

        // If no subscribers need updating, return early
        if ($subscribersToUpdate->isEmpty()) {
            return false;
        }

        // Update the status of these subscribers
        Subscriber::whereIn('id', $subscribersToUpdate->pluck('id'))
            ->update(['is_subscribed' => $data['status'], 'unsubscribed_at' => $data['status'] == 0 ? now() : null]);

        // Send appropriate email notifications
        foreach ($subscribersToUpdate as $subscriber) {
            if ($data['status'] == 0) {
                // Send Unsubscribe Email
                Mail::to($subscriber->email)->send(new UnsubscribedMail($subscriber));
            } else {
                // Send Subscribe Email
                Mail::to($subscriber->email)->send(new SubscribedMail($subscriber));
            }
        }

        return true;
    }

    public function sendBulkMail(array $data)
    {
        $subscribers = Subscriber::whereIn('id', $data['ids'])->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new SubscribedMail($subscriber));
        }
        return true;
    }

    public function delete(int|string $id)
    {
        try {
            $subscriber = Subscriber::findOrFail($id);
            $subscriber->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
