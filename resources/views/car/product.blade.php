@extends('master')
@section('body')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        /* Side Section Styles */
        .side-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-right: 30px;
        }

        .filter-section {
            margin-bottom: 25px;
        }

        .filter-section select,
        .filter-section button,
        .filter-section a {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .filter-section button {
            background-color: #007bff;
            color: white;
        }

        .filter-section a {
            background-color: #ff9800;
            color: white;
        }

        .filter-section button:hover {
            background-color: #0056b3;
        }

        .filter-section a:hover {
            background-color: #e67e22;
        }

        /* Product Section Styles */
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

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            list-style: none;
            padding-left: 0;
        }

        .pagination li {
            display: inline-block;
            margin: 0 5px;
        }

        .pagination a,
        .pagination span {
            padding: 12px 18px;
            border-radius: 5px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination a:hover,
        .pagination a:focus {
            background-color: #007bff;
            color: white;
        }

        .pagination .active span {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        /* Arrow Icons for Next/Prev */
        .pagination a[rel="prev"]::before,
        .pagination a[rel="next"]::before {
            font-family: 'FontAwesome';
            padding-right: 5px;
        }

        .pagination a[rel="prev"]::before {
            content: "\f053";
            /* Left arrow */
        }

        .pagination a[rel="next"]::before {
            content: "\f054";
            /* Right arrow */
        }

        .pagination a[rel="prev"],
        .pagination a[rel="next"] {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Responsive Pagination */
        @media (max-width: 767px) {
            .pagination a,
            .pagination span {
                padding: 10px 12px;
                font-size: 14px;
            }
        }
    </style>

    <div class="container">
        <div class="row">
            <!-- Side Section for Filters and Buttons -->
            <div class="col-md-3">
                <div class="side-section">
                    <h5>Filters & Options</h5>
                    <form action="{{ route('cars.show') }}" method="GET">
                        <div class="filter-section">
                            <!-- Sort by Date -->
                            <select name="date_sort">
                                <option value="" disabled selected>Sort by Date</option>
                                <option value="recent" {{ request('date_sort') == 'recent' ? 'selected' : '' }}>Recent Products First</option>
                                <option value="oldest" {{ request('date_sort') == 'oldest' ? 'selected' : '' }}>Oldest Products First</option>
                            </select>

                            <!-- Sort by Price -->
                            <select name="price_sort">
                                <option value="" disabled selected>Sort by Price</option>
                                <option value="low_to_high" {{ request('price_sort') == 'low_to_high' ? 'selected' : '' }}>Low to High</option>
                                <option value="high_to_low" {{ request('price_sort') == 'high_to_low' ? 'selected' : '' }}>High to Low</option>
                            </select>

                            <!-- Search Button -->
                            <button type="submit" class="btn btn-primary">Search Now</button>
                        </div>
                    </form>
                    <br>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#predictPriceModal">Predict Price</button>
                </div>
            </div>

            <!-- Main Product Section -->
            <div class="col-md-9 product-section">
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
                        <p>No cars match your search criteria.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Predict Price Modal -->
    <div class="modal fade" id="predictPriceModal" tabindex="-1" aria-labelledby="predictPriceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="predictPriceModalLabel">Predict Car Price</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('car.predictPrice') }}" method="POST">
                        @csrf
                        <!-- Form fields for prediction -->
                        {{-- <div class="form-group">
                            <label for="brand">Brand</label>
                            <select name="brand" id="brand" class="form-control" required>
                                <option value="">Select Brand</option>
                                <option value="Toyota" {{ old('brand') == 'Toyota' ? 'selected' : '' }}>Toyota</option>
                                <option value="Honda" {{ old('brand') == 'Honda' ? 'selected' : '' }}>Honda</option>
                                <option value="Ford" {{ old('brand') == 'Ford' ? 'selected' : '' }}>Ford</option>
                                <option value="Nissan" {{ old('brand') == 'Nissan' ? 'selected' : '' }}>Nissan</option>
                                <option value="Hyundai" {{ old('brand') == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                                <option value="Suzuki" {{ old('brand') == 'Suzuki' ? 'selected' : '' }}>Suzuki</option>
                                <option value="Mahendra" {{ old('brand') == 'Mahendra' ? 'selected' : '' }}>Mahendra</option>
                            </select>
                            @error('brand')/
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
            
                             
                        <div class="form-group">
                            <label for="make_year">Make Year</label>
                            <input type="number" name="make_year" id="make_year" class="form-control" value="{{ old('make_year') }}" required>
                            @error('make_year')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="form-group">
                            <label for="fuel_type">Fuel Type</label>
                            <select name="fuel_type" id="fuel_type" class="form-control" required>
                                <option value="Petrol" {{ old('fuel_type') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="Electric" {{ old('fuel_type') == 'Electric' ? 'selected' : '' }}>Electric</option>
                                <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                            @error('fuel_type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="form-group">
                            <label for="cc">CC</label>
                            <input type="number" name="cc" id="cc" class="form-control" value="{{ old('cc') }}" required>
                            @error('cc')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="form-group">
                            <label for="mileage">Mileage</label>
                            <input type="number" step="0.01" name="mileage" id="mileage" class="form-control" value="{{ old('mileage') }}" required>
                            @error('mileage')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="form-group">
                            <label for="seats">Seats</label>
                            <input type="number" name="seats" id="seats" class="form-control" value="{{ old('seats') }}" required>
                            @error('seats')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="form-group">
                            <label for="transmission">Transmission</label>
                            <select name="transmission" id="transmission" class="form-control" required>
                                <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            </select>
                            @error('transmission')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="form-group">
                            <label for="owner_type">Owner Type</label>
                            <select name="owner_type" id="owner_type" class="form-control" required>
                                <option value="First" {{ old('owner_type') == 'First' ? 'selected' : '' }}>First</option>
                                <option value="Second" {{ old('owner_type') == 'Second' ? 'selected' : '' }}>Second</option>
                                <option value="Third" {{ old('owner_type') == 'Third' ? 'selected' : '' }}>Third</option>
                            </select>
                            @error('owner_type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="form-group">
                            <label for="power">Power (bhp)</label>
                            <input type="number" step="0.01" name="power" id="power" class="form-control" value="{{ old('power') }}" required>
                            @error('power')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                             <div class="form-group">
                            <label for="run_distance">Run Distance</label>
                            <input type="number" name="run_distance" id="run_distance" class="form-control" value="{{ old('run_distance') }}" required>
                            @error('run_distance')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                           
                        <button type="submit" class="btn btn-primary w-100">Predict Price</button>
                    </form>
    
                   
                </div>
            </div>
        </div>
    </div>
    
    <!-- JQuery and JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
      $(document).ready(function () {
    // Show the modal when the button is clicked
    $('.btn-warning').on('click', function () {
        $('#predictPriceModal').modal('show');
    });
});

    </script>
    
@endsection
