@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h1 class="text-center mb-5 display-4 fw-bold">Our Products</h1>

    @if ($products->isEmpty())
    <div class="row">
        <div class="">
            <div class="col-md-12">
                <div class="no-prd-error alert text-center" role="alert">
                    <h4 class="mb-0">No products found!</h4>
                </div>
            </div>
        </div>
    </div>
    @else

    <div class="row">
        @foreach($products as $product)


        <div class="col col-md-4 mb-3 prd-grid">
            <div class="card h-100">
                <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">{{ $product->name }}</h5>
                </div>
                <p class="card-text fw-bold mb-4">₹{{ number_format($product->price, 2) }}</p>

                @if(auth()->check())
                <a href="{{ route('product.pay', $product->id) }}" class="btn btn-primary w-100 rounded-pill">Buy Now</a>
                @else
                    <button class="btn btn-primary w-100 rounded-pill" onclick="showLoginAlert({{ $product->id }})">Buy Now</button>
                @endif

                </div>
            </div>
        </div>

        @endforeach
    </div>


        {{-- PAGINATION --}}
         <nav class="mt-4">
            <ul class="pagination justify-content-center">
                @if ($products->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">«</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}">«</a></li>
                @endif

                @foreach ($products->links()->elements[0] as $page => $url)
                    <li class="page-item {{ $products->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($products->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}">»</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">»</span></li>
                @endif
            </ul>
        </nav>

    @endif
</div>
<!-- Include SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function showLoginAlert() {
        Swal.fire({
            title: "You are not logged in!",
            text: "Please log in to view product details.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Login",
            cancelButtonText: "Close",
            customClass: {
                confirmButton: 'btn btn-primary rounded-pill',
                cancelButton: 'btn btn-secondary rounded-pill'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    }
</script>

@endsection
