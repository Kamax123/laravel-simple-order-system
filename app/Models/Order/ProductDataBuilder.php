<?php

namespace App\Models\Order;

use App\Models\ResourceModels\TaxResource;
use Illuminate\Support\Collection;

class ProductDataBuilder
{
    /**
     * @var TaxResource
     */
    private $taxResource;

    public function __construct(
        TaxResource $taxResource
    ) {
        $this->taxResource = $taxResource;
    }

    /**
     * Adds tax and ordered quantity data to the products
     * @param Collection $products
     * @param array $reqQuantities
     * @param int $countryId
     * @return Collection|array
     */
    public function buildProductData(Collection $products, array $reqQuantities, int $countryId)
    {
        foreach ($products as $key => $product) {
            $originalQuantity = $product->quantity;
            $newQuantity = $originalQuantity - $reqQuantities[$key];
            if ($newQuantity < 0) {
                return [
                    'errors' => sprintf(
                        'Product with name %s does not have enough stock to fulfill the order',
                        $product->name
                    )
                ];
            }

            $taxRate = $this->taxResource->getTaxPercentageByCountryId($countryId, $product->id);
            $taxAmount = ($product->price + ($product->price / 100) * $taxRate) - $product->price;

            $product->orderedQuantity = $reqQuantities[$key];
            $product->taxRate = $taxRate;
            $product->taxAmount = number_format((float)$taxAmount, 2, '.', '');
        }

        return $products;
    }
}
