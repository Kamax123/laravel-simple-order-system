<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class StoreController extends Controller
{
    /**
     * Provides products and available countries
     * @return View
     */
    public function getStoreData()
    {
        $products = Product::all();
        $countries = Country::all();

        return view('store.list', compact('products', 'countries'));
    }
}
