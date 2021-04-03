@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3">Ordered Products</h1>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Name</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>Tax Amount</td>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->orderedQuantity }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->taxAmount }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <p>Total before tax: {{ $totals[\App\Models\Order\TotalCalculator::TOTAL_BEFORE_TAX] }}</p>
        <p>Grand total: {{ $totals[\App\Models\Order\TotalCalculator::GRAND_TOTAL] }}</p>
    </div>
@endsection
