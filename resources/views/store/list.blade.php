@extends('base')

@section('main')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-sm-12">
            <form method="post" action="/placeOrder">
            @csrf <!-- {{ csrf_field() }} -->
                <h1 class="display-3">Products</h1>
                @if(count($errors))
                    <div class="form-group">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Quantity</td>
                        <td>Price</td>
                        <td colspan = 1>Choose Quantity</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        @if($product->quantity > 0)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->price}}</td>
                            <td><input name="products[{{$product->id}}]" type="number" min="1" max="{{$product->quantity}}"/></td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <label for="countries">Choose your country:</label>
                <select class="form-select" name="country" id="country">
                    @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>
                <label for="invoice_format">Choose the invoice format</label>
                <select class="form-select" name="invoice_format" id="invoice_format">
                    <option value="json">JSON</option>
                    <option value="html">HTML</option>
                </select>
                <label for="invoice_by_email">Send invoice by e-mail?</label>
                <select class="form-select" name="invoice_by_email" id="invoice_by_email">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <label for="email">Enter your e-mail address:</label>
                <input class="input-group" type="email" id="email" name="email">
                <button type="submit" style="margin-top: 1em" class="btn btn-dark mp10">Send Order</button>
            </form>
        </div>
    </div>
@endsection