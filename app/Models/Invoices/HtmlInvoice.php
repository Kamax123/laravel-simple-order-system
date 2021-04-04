<?php

namespace App\Models\Invoices;

use Illuminate\Support\Collection;

class HtmlInvoice implements InvoiceInterface
{
    /**
     * @inheritDoc
     */
    public function createInvoice(Collection $products, array $totals)
    {
        return view('invoice.html_invoice', compact('products', 'totals'));
    }
}
