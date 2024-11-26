@extends('master')

@section('body')
    <div style="margin: 20px">
        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('cars.requestMeeting', $car->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="description">Meeting Description</label>
                <textarea name="description" id="description" class="form-control" maxlength="500">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="meeting_date">Meeting Date</label>
                <input type="date" name="meeting_date" id="meeting_date" class="form-control" value="{{ old('meeting_date') }}" required>
                @if ($errors->has('meeting_date'))
                    <span class="text-danger">{{ $errors->first('meeting_date') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary btn-request-meeting mt-3">Request Meeting</button>
        </form>
    </div>
@endsection
