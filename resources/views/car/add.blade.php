@extends('master')

@section('body')
    <div class="container">
        <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
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
            </div>

            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" name="model" id="model" class="form-control" value="{{ old('model') }}" required>
                @error('model')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

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

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
                @error('price')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="location">Location or City</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
                @error('location')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}" required>
                @error('contact')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="photos">Photos</label>
                <input type="file" name="photos[]" id="photos" class="form-control" required multiple>
                @error('photos.*')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div id="photo-preview" class="mt-3">
            <!-- Photo previews will be shown here -->
        </div>
    </div>

    <script>
        document.getElementById('photos').addEventListener('change', function() {
            const preview = document.getElementById('photo-preview');
            preview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.width = 100;
                img.classList.add('mr-2');
                preview.appendChild(img);
            });
        });
    </script>

@endsection
