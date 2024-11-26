@extends('master')
@section('body')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-sha256.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
    <div class="container" style="margin-top: -70px">
        <div class="card">
            <div class="card-header">
                <h1>Payment for {{ $car->brand }}, {{ $car->model }}</h1>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{ asset('storage/' . $car->photos->first()->path) }}" alt="Car Image" class="img-fluid rounded">
                </div>
                <p><strong>Seller:</strong> {{ $car->user->name }}</p>
                <p><strong>Price:</strong> <span class="text-success">{{ number_format($car->price) }}</span></p>
                <p><strong>Contact:</strong> <a href="tel:{{ $car->user->phone }}"
                        class="text-primary">{{ $car->user->phone }}</a></p>
                <div class="text-center">
                    <img src="{{ asset('assets/images/esewa.png') }}" alt="eSewa Logo" class="img-fluid"
                        style="max-width: 200px; margin-bottom: 15px;">                 
                    
                
                        <form method="POST" action="{{route('payment.verify')}}">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $car->price * 100 }}">
                            <button type="submit" class="btn btn-primary btn-lg">Proceed to Payment</button>
                        </form>
                                        </div>
            </div>
        </div>
    </div>

    

    <script src="https://khalti.com/static/khalti-checkout.js"></script>
    

    <script>
        var config = {
            // Replace with your public key from Khalti configuration
            "publicKey": "{{ config('khalti.public_key') }}",
            "productIdentity": "{{ $car->id }}", // The car ID for this transaction
            "productName": "{{ $car->brand }} {{ $car->model }}",
            "productUrl": "{{ route('car.details', $car->id) }}", // The product page
            "eventHandler": {
                onSuccess (payload) {
                    // On successful payment, send the payload to your backend for verification
                    fetch("{{ route('payment.verify') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            token: payload.token,
                            amount: payload.amount,
                        })
                    }).then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              alert('Payment successful!');
                          } else {
                              alert('Payment verification failed.');
                          }
                      });
                },
                onError (error) {
                    console.log(error);
                    alert('Something went wrong with the payment.');
                },
                onClose () {
                    console.log('Payment widget closed.');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var button = document.getElementById("payment-button");

        button.onclick = function () {
            var carPriceInPaisa = {{ $car->price * 100 }}; // Convert price to paisa
            checkout.show({ amount: carPriceInPaisa }); // Start Khalti payment
        };
    </script>


@endsection
