@extends('admin/adminDash')

@section('content')
    <div class="container mt-5">

        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <!-- Meeting Details on the Left -->
                <div class="col-md-12 meeting-details">
                    <h2>Meeting Details</h2>

                    <!-- Meeting Information Table -->
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Car</th>
                            <th>Car Price</th>
                            <th>Seller</th>
                            <th>Requester</th>
                            <th>Meeting Date</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($meetings as $index => $meeting)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $meeting->car->brand }} - {{ $meeting->car->model }}</td>
                                <td>{{ $meeting->car->price }}</td>
                                <td>{{ $meeting->seller->name }}</td>
                                <td>{{ $meeting->requested_by_id ? \App\Models\User::find($meeting->requested_by_id)->name : 'N/A' }}</td>
                                <td>{{ $meeting->meeting_date->format('d M Y') }}</td>
                                <td>{{ $meeting->description }}</td>
                                <td>
                                    @if($meeting->status == 'approved')
                                        Approved
                                    @elseif($meeting->status == 'declined')
                                        Rejected
                                    @else
                                        Pending
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Meeting Details Table */
        .meeting-details {
            padding: 15px;
        }

        .meeting-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .meeting-details th, .meeting-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .meeting-details th {
            background-color: #f2f2f2;
        }
    </style>


@endsection
