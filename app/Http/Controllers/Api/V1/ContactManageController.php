<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Interfaces\ContactManageInterface;
use App\Mail\ContactUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactManageController extends Controller
{
    public function __construct(protected ContactManageInterface $contactRepo)
    {

    }

    public function store(ContactRequest $request)
    {
        $success = $this->contactRepo->sendContactMessage($request->all());
        if ($success) {
            return $this->success(__('messages.save_success', ['name' => 'Your message']),200);
        } else {
            return $this->failed(__('messages.currently_not_available'),500);
        }
    }
}
