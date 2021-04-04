<?php

namespace App\Models\Order;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

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
        Event::dispatch('before_calculate_total', $products);

        $grandTotal = 0;
        $totalBeforeTax = 0;
        foreach ($products as $product) {
            $totalBeforeTax+= $product->price * $product->orderedQuantity;
            $grandTotal+= ($product->price + $product->taxAmount) * $product->orderedQuantity;
        }

        $totalBeforeTax = $this->formatTotals($totalBeforeTax);
        $grandTotal = $this->formatTotals($grandTotal);

        Event::dispatch('after_calculate_total', [$products, $totalBeforeTax, $grandTotal]);

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
