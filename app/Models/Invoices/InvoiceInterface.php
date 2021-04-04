<?php

namespace App\Models\Invoices;

use Illuminate\Support\Collection;

interface InvoiceInterface
{
    /**
     * @param Collection $products
     * @param array $totals
     * @return mixed
     */
    public function createInvoice(Collection $products, array $totals);
}

