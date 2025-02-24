<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DynamicEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($args)
    {
        $this->data = $args;
    }

    public function build()
    {
        return $this->from(com_option_get('com_site_global_email'), com_option_get('com_site_title'))->subject($this->data['subject'])->markdown('emails.dynamic-template');
    }
}
