<?php

namespace App\Models\ResourceModels;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TaxResource
{
    /**
     * @param int $countryId
     * @param array $productIds
     * @return Collection
     */
    public function getTaxPercentageByProductIds(int $countryId, array $productIds): Collection
    {
        return DB::table('taxes')
            ->where('country_id', $countryId)
            ->whereIn('product_id', $productIds)
            ->get()
            ->keyBy('product_id');
    }
}
