<?php

namespace Database\Factories;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $country_id = 1;
        static $product_id = 1;

        $values = [
            'product_id' => $product_id,
            'country_id' => $country_id++,
            'percentage' => $this->faker->numberBetween(1, 20)
        ];

        if ($country_id == 11) {
            $country_id = 1;
            $product_id++;
        }

        return $values;
    }
}
