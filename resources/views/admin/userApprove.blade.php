@extends('admin/adminDash')

@section('content')
    <div class="container mt-5">
        <div class="card p-4">
            <h2 class="card-title">User Verification Requests</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Request Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <!-- Approve Button -->
                            <form action="{{ route('user.approve', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>

                            <!-- Reject Button -->
                            <form action="{{ route('user.reject', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
