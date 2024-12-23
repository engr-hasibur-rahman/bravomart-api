<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable

{
    use Queueable, SerializesModels;

    public $customer;
    public $token;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->token = $customer->email_verify_token; // Store the token here
    }

    public function build()
    {
        return $this->subject('Email Verification') // Email subject
        ->view('mail.email-verification-mail') // View path
        ->with([
            'customer' => $this->customer, // Pass the customer object
            'token' => $this->token, // Pass the token
        ]);
    }
}

