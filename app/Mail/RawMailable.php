<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RawMailable extends Mailable
{
    use Queueable, SerializesModels;

    private $mailTo;
    private $mailSubject;
    private $mailFrom;

    public $content;

    public function __construct($from, $to, $subject, $content)
    {
        $this->content = $content;
        $this->mailSubject = $subject;
        $this->mailTo = $to;
        $this->mailFrom = $from;
    }

    /**
     * Build the message.
     *
     * @throws Exception
     */
    public function build()
    {
        $this->view('emails.raw');

        $this->subject($this->mailSubject)
            ->from($this->mailFrom)
            ->to($this->mailTo);
    }
}
