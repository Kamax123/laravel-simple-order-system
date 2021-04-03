<?php

namespace App\Models\Invoices;

interface InvoiceInterface
{
    public function createInvoice($products, $totals);
}

