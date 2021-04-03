<?php

namespace App\Models\Invoices;

class HtmlInvoice implements InvoiceInterface
{
    public function createInvoice($products, $totals)
    {
        return view('invoice.html_invoice', compact('products', 'totals'));
    }
}
