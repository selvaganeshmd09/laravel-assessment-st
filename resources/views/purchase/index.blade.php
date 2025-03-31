@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5 display-4 fw-bold">Ready to Purchase!</h1>


    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
          <div class="card shadow-lg border-0">
            <div class="card-body p-4">
              <div class="mb-3 text-center">
                <span class="badge bg-orange-light text-orange">Pay for</span>
              </div>
              <div class="d-flex align-items-center mb-4">
                <div class="bg-orange-light rounded-circle p-3 me-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.29 7 12 12 20.71 7"></polyline>
                    <line x1="12" y1="22" x2="12" y2="12"></line>
                  </svg>
                </div>
                <h2 class="h3 mb-0">{{ $product->name }}</h2>
              </div>

              <div class="bg-light rounded-3 p-4 mb-4">
                <p class="lead mb-0">
                    {{ $product->description }}
                </p>
              </div>

              <div class="mb-4">
                <span class="h2 text-orange mb-0">₹{{ number_format($product->price, 2) }}</span>
              </div>

              <form id="payment-form">
                <div class="stripe-element mb-4">
                    <div class="mb-3">
                        <label for="card-element" class="form-label">Enter Card Details</label>
                        <div id="card-element" class="form-control pt-3 pb-3"></div>
                        <span id="card-errors" class="text-danger"></span>
                    </div>
                </div>
                <button type="button" id="payNowButton" class="btn btn-primary rounded-pill w-100">
                  Pay ₹{{ number_format($product->price, 2) }}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
{{-- Stripe JS --}}
<script src="https://js.stripe.com/v3/"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let stripe = Stripe("{{ env('STRIPE_KEY') }}");
        let elements = stripe.elements();
        let card = elements.create("card");
        card.mount("#card-element");

        $("#payNowButton").click(function (e) {
            e.preventDefault();

            stripe.confirmCardPayment("{{ $clientSecret }}", {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: $("#card-holder-name").val()
                    }
                }
            }).then(function (result) {


                if (result.error) {
                    $("#card-errors").text(result.error.message);
                } else {
                    // console.log("result: " + result.paymentIntent.id);
                    $('#payNowButton').text('Processing...');
                    $('#payNowButton').prop('disabled', true);
                    checkPaymentStatus(result.paymentIntent.id);
                }
            });
        });

        function checkPaymentStatus(paymentId) {
            // console.log("paymentId": " + paymentId);

            let interval = setInterval(function () {
                let statusUrl = "{{ route('payment.status', ['paymentId' => '__PAYMENT_ID__']) }}".replace('__PAYMENT_ID__', paymentId);

                $.ajax({
                    url: statusUrl,
                    type: "GET",
                    success: function (response) {
                        // console.log("response:", response.status);
                        if (response.status === "succeeded") {
                            clearInterval(interval);
                            window.location.href = "{{ route('payment.success') }}";
                        } else if (response.status === "failed") {
                            clearInterval(interval);
                            window.location.href = "{{ route('payment.error') }}";
                        }else if(response.status === "pending") {

                            setTimeout(function() {
                                window.location.href = "{{ route('products.list') }}";
                            }, 2000);
                        }
                    },
                    error: function (xhr) {
                        // console.error("Error:", xhr.responseText);
                    }
                });
            }, 3000);
        }


    });
</script>


@endsection
