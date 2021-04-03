<?php

namespace App\Models\Order;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\ResourceModels\ProductResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaveOrder
{
    /**
     * @var ProductResource
     */
    private $productResource;

    public function __construct(
        ProductResource $productResource
    ) {
        $this->productResource = $productResource;
    }

    /**
     * Saves order to database
     * @param Collection $products
     * @param array $totals
     * @return void
     */
    public function save(Collection $products, array $totals)
    {
        DB::beginTransaction();

        try {
            $order = new Order();
            $order->total_before_tax = $totals[TotalCalculator::TOTAL_BEFORE_TAX];
            $order->grand_total = $totals[TotalCalculator::GRAND_TOTAL];
            $order->save();

            foreach ($products as $product) {
                $totalQuantity = $product->quantity - $product->orderedQuantity;
                $orderItem = new OrderItems();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product->id;
                $orderItem->product_name = $product->name;
                $orderItem->quantity = $product->orderedQuantity;
                $orderItem->price = $product->price;
                $orderItem->tax_amount = $product->taxAmount;

                $this->productResource->updateProductQuantity($product->id, (int)$totalQuantity);

                $orderItem->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }
}
