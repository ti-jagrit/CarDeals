@extends('master')

@section('body')
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="container">
                <div class="row">
                    <!-- Large Photo Container and Thumbnails on the Left -->
                    <div class="col-md-7 photo-container">
                        <!-- Large Photo Container -->
                        <div id="largePhoto" class="car-photo-large" style="background-image: url('{{ $car->photos->first() ? asset('storage/' . $car->photos->first()->path) : asset('assets/images/banner-placeholder.jpeg') }}');"></div>


                        <!-- Small Photo Thumbnails -->
                        <div class="d-flex mt-2">
                            @foreach($car->photos as $photo)
                            <div class="car-photo-small" style="background-image: url('{{ asset('storage/' . $photo->path) }}');" 
                                onclick="changePhoto('{{ asset('storage/' . $photo->path) }}')">
                            </div>
                            
                            @endforeach
                        </div>
                    </div>

                    <!-- Car Details on the Right -->
                    <div class="col-md-5 car-details">
                        <h2>{{ $car->brand }} - {{ $car->make_year }}</h2>
                        <p><strong>Fuel Type:</strong> {{ $car->fuel_type }}</p>
                        <p><strong>Engine CC:</strong> {{ $car->cc }}cc</p>
                        <p><strong>Run Distance:</strong> {{ $car->run_distance }} km</p>
                        <p><strong>Location:</strong> {{ $car->location }}</p>
                        <p><strong>Contact:</strong> {{ $car->contact }}</p>
                    
                        <p><strong>Price:</strong>  {{ number_format($car->price) }}</p>
                    

                        <p><strong>Seller:</strong> {{ $car->user->name }}</p>

                        <a href="{{route('cars.showMeetingForm',$car->id)}}">
                            <button class="btn btn-primary btn-request-meeting mt-3">Request Meeting</button>
                        </a>
                        {{-- <a href="{{route('cars.showPayment',$car->id)}}">
                            <button class="btn btn-danger btn-request-meeting mt-3">Book Now</button>
                        </a> --}}
                    </div>
                </div>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Get all photo URLs from data attributes
                    var photos = @json($car->photos->pluck('path'));

                    // Function to change the large photo
                    function changePhoto(photoUrl) {
                        var largePhoto = document.getElementById('largePhoto');
                        largePhoto.style.backgroundImage = 'url(' + photoUrl + ')';
                    }

                    // Shuffle photos and update the large photo at regular intervals
                    function shufflePhotos() {
                        if (photos.length > 0) {
                            var randomIndex = Math.floor(Math.random() * photos.length);
                            var photoUrl = '{{ asset('storage/') }}/' + photos[randomIndex];
                            changePhoto(photoUrl);
                        }
                    }

                    // Change the photo every 5 seconds (5000 milliseconds)
                    setInterval(shufflePhotos, 3000);

                    // Initialize with the first photo
                    if (photos.length > 0) {
                        changePhoto('{{ asset('storage/' . $car->photos->first()->path) }}');
                    }

                    // Update large photo when a thumbnail is clicked
                    window.changePhoto = changePhoto;
                });
            </script>


            <style>
        /* Large Photo Container */
        .car-photo-large {
            width: 100%;
            height: 400px; /* Adjust the height as needed */
            background-size: cover;
            background-position: center;
            border: 1px solid #ddd;
        }

        /* Small Photo Thumbnails */
        .car-photo-small {
            width: 80px; /* Adjust the size as needed */
            height: 60px; /* Adjust the size as needed */
            background-size: cover;
            background-position: center;
            margin-right: 5px;
            cursor: pointer;
            border: 1px solid #ddd;
        }

        .car-photo-small:hover {
            border: 2px solid #fe5b29; /* Highlight color for selected thumbnail */
        }

        /* Car Details */
        .car-details {
            padding-left: 15px;
        }

    </style>
            <!-- Recommended Cars section -->
            <h2>Recommended Cars</h2>
            <div class="row">
                @foreach ($recommendedCars as $recommendedCar)
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $recommendedCar->photos->first()->path) }}" class="card-img-top" alt="{{ $recommendedCar->brand }} {{ $recommendedCar->model }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $recommendedCar->brand }} {{ $recommendedCar->model }}</h5>
                                <p class="card-text">Price: {{ $recommendedCar->price }}</p>
                                <a href="{{ route('car.details', $car->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

    </div>

@endsection
