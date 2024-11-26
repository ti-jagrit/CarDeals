@extends('master')

@section('body')
    <div class="container mt-5">
        <h2>Step 2: Set Your Price and Upload Photos</h2>

        <form action="{{ route('cars.storeStep2') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Show Predicted Price -->
            <div class="form-group">
                <label for="predicted_price">Predicted Price</label>
                <input type="text" id="predicted_price" class="form-control" value="{{ session('predicted_price') }}" readonly>
            </div>

            <!-- User Price Input -->
            <div class="form-group">
                <label for="price">Your Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
               
            </div>

            <!-- Contact Input -->
            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}" required>
                @error('contact')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Photo Upload Input -->
            <div class="form-group">
                <label for="photos">Photos</label>
                <input type="file" name="photos[]" id="photos" class="form-control" required multiple>
                @error('photos.*')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <!-- Preview Photos -->
            <div id="photo-preview" class="mt-3">
              
            </div>

            
        </form>
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
