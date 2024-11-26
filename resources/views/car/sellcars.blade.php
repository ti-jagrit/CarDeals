@extends('master')

@section('body')
    <div class="container">
        <center>
            <h1 style="background-color: #2d3748; color: yellow; font-weight: bold;">My Cars</h1>
        </center>

        <a href="{{ route('cars.createStep1') }}" class="btn btn-primary mb-2">Add Car</a>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('meetings.index') }}" class="btn btn-success mb-2">My Meetings</a>


        <div class="row">
            @forelse ($cars as $car)
                <div class="col-md-4 mb-4 d-flex justify-content-center">
                    <!-- Card is wrapped in an anchor tag -->
                    <a href="{{ route('cars.details.show', ['car' => $car->id]) }}" style="text-decoration: none; color: inherit;">
                        <div class="card" style="width: 300px; height: 450px;">
                            <div class="gallery_box">
                                @if($car->photos->isNotEmpty())
                                    <div class="gallery_img" style="width: 100%; height: 200px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $car->photos->first()->path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <div class="gallery_img" style="width: 100%; height: 200px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset('images/placeholder.jpg') }}" style="max-width: 50%; max-height: 50%;" alt="Placeholder">
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h3 class="types_text">{{ $car->brand }} - {{ $car->make_year }}</h3>
                           
                                <p class="looking_text">Price: {{ $car->price }}</p>
                                <p class="looking_text">Added: {{ $car->created_at->format('F j, Y') }}</p>
                            </div>
                            @if($car->is_sold)
                            <span class="badge bg-danger "style="font-size: 8pt; color: white">Sold</span>
                            @else
                            <form action="{{ route('cars.markAsSold', $car->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="text text-success"><strong>Mark as Sold </strong></button>
                            </form>

                            @endif
                        </div>
                    </a>

                </div>
            @empty
                <p>No cars added yet.</p>
            @endforelse
        </div>
    </div>


@endsection
