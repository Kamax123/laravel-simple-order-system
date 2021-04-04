@extends('base')

@section('main')
    <p>Order placed successfully!</p>
    <form>
        <input type="button" class="btn btn-primary" value="Place a new order" onclick="window.location='/';">
    </form>
@endsection