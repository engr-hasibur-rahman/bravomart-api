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

    public $subjectLine;
    public $template;
    public $data;

    public function __construct($subjectLine, $template, $data)
    {
        $this->subjectLine = $subjectLine;
        $this->template = $template;
        $this->data = $data;
    }

    public function build()
    {
        $processedTemplate = $this->template;

        foreach ($this->data as $key => $value) {
            $processedTemplate = str_replace("{{ $key }}", e($value), $processedTemplate);
        }

        return $this->subject($this->subjectLine)
            ->html($processedTemplate);
    }
}
