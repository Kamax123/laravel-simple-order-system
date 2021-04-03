<?php

namespace App\Models\Invoices;

use App\Models\Order\TotalCalculator;

class JsonInvoice implements InvoiceInterface
{
    public function createInvoice($products, $totals)
    {
        $productData = [];
        $invoiceData = [];

        foreach ($products as $product) {
            $productData[]['name'] = $product->name;
            $productData[]['quantity'] = $product->orderedQuantity;
            $productData[]['price'] = $product->price;
            $productData[]['taxAmount'] = $product->taxAmount;
        }

        $invoiceData['products'] = $productData;
        $invoiceData['total_before_tax'] = $totals[TotalCalculator::TOTAL_BEFORE_TAX];
        $invoiceData['grand_total'] = $totals[TotalCalculator::GRAND_TOTAL];

        return json_encode($invoiceData);
    }
}
