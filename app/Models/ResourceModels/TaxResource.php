<?php

namespace App\Models\ResourceModels;

use Illuminate\Support\Facades\DB;

class TaxResource
{
    /**
     * @param $country
     * @return float
     */
    public function getTaxPercentageByCountryId($countryId, $productId): float
    {
        return DB::table('taxes')
            ->where('country_id', $countryId)
            ->where('product_id', $productId)
            ->first()->percentage;
    }
}
