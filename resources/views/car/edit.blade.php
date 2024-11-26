@extends('master')
@section('body')
    <div class="container mt-5">
        <h2>Edit Car Details</h2>

        <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $car->brand) }}" required>
            </div>

            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" name="model" id="model" class="form-control" value="{{ old('model', $car->model) }}" required>
            </div>

            <div class="form-group">
                <label for="make_year">Make Year</label>
                <input type="number" name="make_year" id="make_year" class="form-control" value="{{ old('make_year', $car->make_year) }}" required>
            </div>

            <div class="form-group">
                <label for="fuel_type">Fuel Type</label>
                <input type="text" name="fuel_type" id="fuel_type" class="form-control" value="{{ old('fuel_type', $car->fuel_type) }}" required>
            </div>

            <div class="form-group">
                <label for="cc">Engine CC</label>
                <input type="number" name="cc" id="cc" class="form-control" value="{{ old('cc', $car->cc) }}" required>
            </div>

            <div class="form-group">
                <label for="mileage">Mileage</label>
                <input type="number" name="mileage" id="mileage" class="form-control" value="{{ old('mileage', $car->mileage) }}">
            </div>

            <div class="form-group">
                <label for="predicted_price">Predicted Price</label>
                <input type="number" name="predicted_price" id="predicted_price" class="form-control" value="{{ old('predicted_price', $car->predicted_price) }}">
            </div>

            <div class="form-group">
                <label for="run_distance">Run Distance</label>
                <input type="number" name="run_distance" id="run_distance" class="form-control" value="{{ old('run_distance', $car->run_distance) }}" required>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $car->location) }}" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact', $car->contact) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $car->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="photos">Existing Photos</label>
                <div class="row">
                    @foreach($car->photos as $photo)
                        <div class="col-md-3 mb-2">
                            <div class="photo-container">
                                <img src="{{ asset('storage/' . $photo->path) }}" class="img-thumbnail" alt="Car Photo">
                                <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="new_photos">Upload New Photos (Max 4)</label>
                <input type="file" name="photos[]" id="new_photos" class="form-control" multiple>
            </div>


            <button type="submit" class="btn btn-primary mt-3">Update Car</button>
        </form>
    </div>
    @endsection
