@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header bg-primary">
                        <h2 class="text-white">Payment Successful!</h2>
                </div>

                <div class="card-body">
                    <h5 class="p-4">Your order has been processed successfully.</h5>
                    <a href="{{ route('products.list') }}" class="btn btn-primary rounded-pill">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


