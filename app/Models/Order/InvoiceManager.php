<?php

namespace App\Models\Order;

use App\Http\Controllers\MailController;
use App\Models\Invoices\HtmlInvoice;
use App\Models\Invoices\JsonInvoice;
use Illuminate\Support\Facades\Log;

/**
 * Generates invoice based on type and sends it by e-mail if it's requested
 * Class InvoiceManager
 * @package App\Models\Order
 */
class InvoiceManager
{
    const ALLOWED_FORMATS = ['json', 'html'];

    /**
     * @var JsonInvoice
     */
    private $jsonInvoice;

    /**
     * @var HtmlInvoice
     */
    private $htmlInvoice;

    /**
     * @var MailController
     */
    private $invoiceMail;

    public function __construct(
        JsonInvoice $jsonInvoice,
        MailController $invoiceMail,
        HtmlInvoice $htmlInvoice
    ) {
        $this->jsonInvoice = $jsonInvoice;
        $this->invoiceMail = $invoiceMail;
        $this->htmlInvoice = $htmlInvoice;
    }

    public function generateInvoice(string $format, $products, array $totals, bool $byEmail, string $email = null)
    {
        if (!in_array($format, self::ALLOWED_FORMATS))
        {
            Log::error(sprintf(
                'Invoice format %s is not supported',
                $format
            ));

            return false;
        }

        try {
            $invoice = null;

            if ($format === 'json') {
                $invoice = $this->jsonInvoice->createInvoice($products, $totals);
            }

            if ($format === 'html') {
                $invoice = $this->htmlInvoice->createInvoice($products, $totals);
            }

            if (!$byEmail) {
                return $format === 'json' ? $invoice : $invoice->render();
            }

            $this->invoiceMail->sendInvoiceMail($invoice, $email);

            return view('order.success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return false;
    }
}
