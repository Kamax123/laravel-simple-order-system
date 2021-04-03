<?php

namespace App\Models\ResourceModels;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductResource
{
    /**
     * @param array $productIds
     * @return Collection
     */
    public function getProductsByIds(array $productIds): Collection
    {
        return DB::table('products')->whereIn('id', $productIds)->get();
    }

    /**
     * @param int $productId
     * @param int $quantity
     * @return void
     */
    public function updateProductQuantity(int $productId, int $quantity)
    {
        DB::table('products')
            ->where('id', $productId)
            ->update(['quantity' => $quantity]);
    }
}
