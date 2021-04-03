<?php

namespace App\Http\Controllers;

use App\Models\Order\InvoiceManager;
use App\Models\Order\ProductDataBuilder;
use App\Models\Order\SaveOrder;
use App\Models\Order\TotalCalculator;
use App\Models\ResourceModels\ProductResource;
use Illuminate\Http\Request;


/**
 * Controller for placeOrder route intended for handling order process
 */
class OrderController extends Controller
{
    /**
     * @var TotalCalculator
     */
    private $totalCalculator;

    /**
     * @var ProductResource
     */
    private $productResource;

    /**
     * @var SaveOrder
     */
    private $orderProcessor;

    /**
     * @var ProductDataBuilder
     */
    private $dataBuilder;

    /**
     * @var InvoiceManager
     */
    private $invoiceManager;

    public function __construct(
        TotalCalculator $totalCalculator,
        ProductResource $productResource,
        SaveOrder $orderProcessor,
        ProductDataBuilder $dataBuilder,
        InvoiceManager $invoiceManager
    ) {
        $this->totalCalculator = $totalCalculator;
        $this->productResource = $productResource;
        $this->orderProcessor = $orderProcessor;
        $this->dataBuilder = $dataBuilder;
        $this->invoiceManager = $invoiceManager;
    }

    public function placeOrder(Request $request)
    {
        $reqProducts = $this->validateRequestedProducts($request->products);
        if (\array_key_exists('errors', $reqProducts)) {
            return redirect()->back()->withErrors(['errors' => $reqProducts['errors']]);
        }

        $requiredFields = [
            'products' => 'required|array',
            'country' => 'required|string',
            'invoice_format' => 'required|string',
            'invoice_by_email' => 'required|bool',
        ];
        if ($request->invoice_by_email) {
            $requiredFields['email'] = 'required|email';
        }

        $request->validate($requiredFields);

        $quantities = \array_values($reqProducts);
        $productIds = \array_keys($reqProducts);
        $email = $request->email ?? null;
        $invoiceFormat = $request->invoice_format;
        $byEmail = $request->invoice_by_email;
        $countryId = $request->get('country');

        $products = $this->productResource->getProductsByIds($productIds);
        $productsData = $this->dataBuilder->buildProductData($products, $quantities, $countryId);

        // Do not allow placing order if products do not have sufficient stock
        if (\is_array($productsData) && \array_key_exists('errors', $productsData)) {
            return redirect()->back()->withErrors(['errors' => $productsData['errors']]);
        }

        $totals = $this->totalCalculator->calculateTotals($products);
        $this->orderProcessor->save($products, $totals);

        return $this->invoiceManager->generateInvoice($invoiceFormat, $products, $totals, $byEmail, $email);
    }

    /**
     * @param $reqProducts
     * @return array|string[]
     */
    private function validateRequestedProducts($reqProducts): array
    {
        // Filter out null and 0 values
        $reqProducts = array_filter($reqProducts);
        if (empty($reqProducts))
        {
            return ['errors' => 'Please select a quantity for at least one product'];
        }

        foreach ($reqProducts as $productQuantity) {
            if ((int)$productQuantity < 0) {
                return ['errors' => 'Product quantity cannot be negative'];
            }
        }

        return $reqProducts;
    }
}

