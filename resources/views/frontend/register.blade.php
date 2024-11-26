<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{asset('assets/images/logo.png')}}" type="image/x-icon" />
    <style>
        .bg-orange {
            background-color: #ff9800;
        }
        .btn-orange {
            background-color: #ff9800;
            border: none;
        }
        .btn-orange:hover {
            background-color: #e68900;
        }
        .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 600px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Register</h2>
            <form action="{{ route('user_registration') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter your name" value="{{ old('name') }}" >
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter your email" value="{{ old('email') }}" >
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter your password" >
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="confirmPassword" placeholder="Confirm your password" >
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter your phone number" value="{{ old('phone') }}" >
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="citizenship" class="form-label">Citizenship</label>
                        <input type="text" name="citizenship" class="form-control @error('citizenship') is-invalid @enderror" id="citizenship" placeholder="Enter your citizenship" value="{{ old('citizenship') }}" >
                        @error('citizenship')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" id="photo">
                    @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-orange text-white">Register</button>
                </div>
                <div class="mb-3">
                    <label for="register" class="form-label">Already Have Account? </label>
                    <a href="{{route('login')}}"> Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
