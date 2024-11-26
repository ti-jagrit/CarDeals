@extends('admin/adminDash')

@section('content')
    <div class="container mt-5">
        <div class="card p-4">
            <h2 class="card-title">Car Management</h2>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Car</th>
                    <th>Price</th>
                    <th>Make Year</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Predicted Price</th>
                    <th>Seller</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cars as $index => $car)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $car->brand }} - {{ $car->model }}</td>
                        <td>{{ number_format($car->price) }}</td>
                        <td>{{ $car->make_year }}</td>
                        <td>{{ $car->contact }}</td>
                        <td>{{ $car->location }}</td>
                        <td>{{ number_format($car->predicted_price) }}</td>
                        <td>{{ $car->user->name }}</td>
                        <td>
                            <!-- Delete Button -->
                            <form action="{{ route('admin.car.delete', $car->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
