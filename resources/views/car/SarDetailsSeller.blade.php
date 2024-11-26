@extends('master')
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

@section('body')
    <div class="container mt-5" style="margin-top:-70px; margin-buttom:10px;" >

        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <!-- Large Photo Container and Thumbnails on the Left -->
                <div class="col-md-7 photo-container">
                    <!-- Large Photo Container -->
                    <div id="largePhoto" class="car-photo-large"style="background-image: url('{{ $car->photos->isNotEmpty() ? asset('storage/' . $car->photos->first()->path) : asset('assets/images/banner-placeholder.jpeg') }}');">

                    </div>


                    <!-- Small Photo Thumbnails -->
                    <div class="d-flex mt-2">
                        @foreach($car->photos as $photo)
                              <div class="car-photo-small" style="background-image: url('{{ asset('storage/' . $photo->path) }}');" onclick="changePhoto('{{ asset('storage/' . $photo->path) }}')"></div>
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
                    @if($car->predicted_price!=null)
                    <p><strong>Predictd Price:</strong> {{ $car->predicted_price}} Lakhs</p>
                    @endif
                    <p><strong>Seller:</strong> {{ $car->user->name }}</p>

                    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning mt-3">Edit</a>

                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-3">Delete</button>
                    </form>

                    <form action="{{ route('cars.markAsSold', $car->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success mt-3">Mark as Sold</button>
                    </form>
                </div>
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
    changePhoto('{{ $car->photos->isNotEmpty() ? asset('storage/' . $car->photos->first()->path) : asset('assets/images/banner-placeholder.jpeg') }}');
}


                    // Update large photo when a thumbnail is clicked
                    window.changePhoto = changePhoto;
                });
            </script>


            




@endsection
