@extends('master')

@section('body')
    <style>
    .product-card {
    border: 1px solid #fe5b29; /* Primary color */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s, transform 0.3s;
    overflow: hidden; /* Ensure content stays within rounded corners */
    }

    .product-card .card-img-top {
    width: 100%;
    height: 200px; /* Adjust height as needed */
    object-fit: cover; /* Ensure image covers the area without distortion */
    }

    .product-card:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
    }

    .product-card .card-title {
    color: #fe5b29; /* Primary color */
    font-size: 1.25rem;
    font-weight: bold;
    }

    .product-card .card-body {
    padding: 1.5rem;
    }

    .product-card .btn-success {
    background-color: #fe5b29; /* Primary color */
    border-color: #fe5b29;
    }

    .product-card .btn-success:hover {
    background-color: #e74c3c;
    border-color: #e74c3c;
    }

    .product-card .btn-danger {
    background-color: #d9534f;
    border-color: #d9534f;
    }

    .product-card .btn-danger:hover {
    background-color: #c9302c;
    border-color: #ac2925;
    }
    </style>

    <div class="container">
      <center>  <h3>My Meetings</h3> </center>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($meetings->isEmpty())
            <p>No meetings found.</p>
        @else
            <div class="row">
                @foreach($meetings as $meeting)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card">

                            <div class="card-body">
                                <h5 class="card-title">{{ $meeting->car->brand }} - {{ $meeting->car->model }}</h5>
                                <p><strong>Meeting Date:</strong> {{ $meeting->meeting_date->format('d M Y') }}</p>
                                <p><strong>Description:</strong> {{ $meeting->description ?? 'N/A' }}</p>
                                <p><strong>Status:</strong> {{ $meeting->status }}</p>

                                @if(auth()->id() === $meeting->seller_id)
                                    {{-- If the user is the car owner --}}
                                    @if($meeting->status === 'Pending')
                                        <form action="{{ route('meetings.approve', $meeting->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </form>

                                        <button class="btn btn-danger" onclick="showDeclineForm({{ $meeting->id }})">Decline</button>

                                        <form id="declineForm{{ $meeting->id }}" action="{{ route('meetings.decline', $meeting->id) }}" method="POST" style="display: none; margin-top: 10px;">
                                            @csrf
                                            <div class="form-group">
                                                <label for="rejection_details{{ $meeting->id }}">Decline Remarks</label>
                                                <textarea name="rejection_details" id="rejection_details{{ $meeting->id }}" class="form-control" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-danger mt-2">Submit Decline</button>
                                        </form>
                                    @elseif($meeting->status === 'Approved')
                                        <div class="card mt-4">
                                            <div class="card-body">
                                                <h5 class="card-title">You have a meeting scheduled.</h5>
                                                <p class="card-text">Meeting is scheduled on {{ $meeting->meeting_date->format('d M Y') }}.</p>
                                            </div>
                                        </div>
                                    @endif
                                @elseif(auth()->id() === $meeting->requested_by_id)
                                    {{-- If the user is the meeting requester --}}

                                        @if($meeting->status === 'Rejected')
                                       <h5>     <span class="text-danger">Rejected</span></h5>
                                      <p class="text text-danger"> <strong> {{ $meeting->rejection_details ?? 'N/A' }} </strong></p>
                                        <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this meeting request?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>



                                    @elseif($meeting->status === 'Approved')
                                    <h5>     <strong> <span class="text-success ">Approved</span> </strong></h5>
                                        @else
                                            <span class="text-warning">Pending</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        function showDeclineForm(meetingId) {
            document.getElementById('declineForm' + meetingId).style.display = 'block';
        }
    </script>@endsection
