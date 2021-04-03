<?php

namespace App\Http\Controllers;

use App\Mail\RawMailable;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * @param mixed $invoice
     * @param string $to
     */
    public function sendInvoiceMail($invoice, string $to)
    {
        $subject = 'Your Order Invoice';
        $from = 'demo@laravelstore.com';
        Mail::send(new RawMailable($from, $to, $subject, $invoice));
    }
}
