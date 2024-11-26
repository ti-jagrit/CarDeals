@extends('master')
@section('body')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        /* Custom styles here (if needed) */
        .predicted-price {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        .product-section {
            padding-left: 0;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .car-card img {
            max-height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .card-text {
            font-size: 14px;
            color: #555;
        }

        .btn-danger {
            background-color: #fe5b29;
            border: none;
            width: 100%;
            padding: 10px;
        }

        .btn-danger:hover {
            background-color: #e74c3c;
        }
    </style>

    <div class="container">
        <div class="row">
            <!-- Predicted Price Display -->
            <div class="col-md-12">
                <h1> Prediced Price: {{$predictedPrice}} </h1>
                <div class="predicted-price">
                    Predicted Price Range: {{ number_format($predictedPrice - 50000) }} - {{ number_format($predictedPrice + 50000) }}
                </div>
            </div>

            <!-- Main Product Section -->
            <div class="col-md-12 product-section">
                <div class="row">
                    @forelse ($cars as $car)
                        @if (!$car->is_sold)
                            <div class="col-md-4">
                                <a href="{{ route('car.details', $car->id) }}" class="text-decoration-none">
                                    <div class="card car-card">
                                        @if ($car->photos->isNotEmpty())
                                            <img src="{{ asset('storage/' . $car->photos->first()->path) }}" class="card-img-top" alt="Car Photo">
                                        @else
                                            <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top" alt="Placeholder">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $car->brand }} - {{ $car->make_year }}</h5>
                                            <p class="card-text">
                                                <strong>Run Distance:</strong> {{ $car->run_distance }} km<br>
                                                <strong>Price:</strong> {{ number_format($car->price) }}<br>
                                                <strong>Location:</strong> {{ $car->location }}<br>
                                                <strong>Added:</strong> {{ $car->created_at->format('F j, Y') }}
                                            </p>
                                        </div>
                                        <div class="text-center mb-3">
                                            <a href="{{ route('car.details', $car->id) }}" class="btn btn-danger">Buy Now</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @empty
                        <p>No cars found within the predicted price range.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
