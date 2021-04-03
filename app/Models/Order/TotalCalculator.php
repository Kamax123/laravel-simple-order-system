<?php

namespace App\Models\Order;

use Illuminate\Support\Collection;

class TotalCalculator
{
    const TOTAL_BEFORE_TAX = 'totalBeforeTax';
    const GRAND_TOTAL = 'grandTotal';

    /**
     * Calculates order totals based on country tax percentage for each individual product
     * @param Collection $products
     * @return float[]|int[]
     */
    public function calculateTotals(Collection $products): array
    {
        $grandTotal = 0;
        $totalBeforeTax = 0;
        foreach ($products as $product) {
            $totalBeforeTax+= $product->price * $product->orderedQuantity;
            $grandTotal+= ($product->price + $product->taxAmount) * $product->orderedQuantity;
        }

        $totalBeforeTax = $this->formatTotals($totalBeforeTax);
        $grandTotal = $this->formatTotals($grandTotal);

        return [
            self::TOTAL_BEFORE_TAX => $totalBeforeTax,
            self::GRAND_TOTAL => $grandTotal
        ];
    }

    /**
     * @param $total
     * @return string
     */
    private function formatTotals($total): string
    {
        return number_format((float)$total, 2, '.', '');
    }
}
