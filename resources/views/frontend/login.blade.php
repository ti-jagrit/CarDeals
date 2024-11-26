<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
  </style>
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Login</h2>
               <form action="{{route('loginMatch')}}" method="post">
          @csrf
          @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif
      
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{old('email')}}">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="{{old('password')}}">
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-orange text-white">Login</button>
          </div>
          <div class="mb-3">
            <label for="register" class="form-label">Dont Have Account? </label>
            <a href="{{route('register')}}"> Register</a>
          </div>

        </form>
      </div>
      @if ($errors->any())
        <div class="card-footer text-body-secondary">
          <div>
            <ul  style="background: red; color:white; padding: 5px; font-weight: bold; text-align: center;">
              @foreach ($errors->all() as $error )
              <li>{{$error}}</li>
              @endforeach
            </ul>
          </div>
        </div>
      @endif
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
