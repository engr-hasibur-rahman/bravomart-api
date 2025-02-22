<?php

namespace App\Jobs;

use App\Mail\DynamicEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendDynamicEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recipient;
    protected $subject;
    protected $template;
    protected $data;

    public function __construct($recipient, $subject, $template, $data)
    {
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->template = $template;
        $this->data = $data;
    }

    public function handle(): void
    {
        Mail::to($this->recipient)->send(new DynamicEmail($this->subject, $this->template, $this->data));
    }
}
