<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 300px;
            background-color: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 1.2rem;
        }
        .sidebar h4 {
            margin-top: 15px;
            color: #ff6b39;
            font-size: 2rem;
            border-bottom: 3px solid white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }
        .sidebar a:hover {
            color: #fe5b29;
            background: white;
        }
        .content {
            margin-left: 300px;
            padding: 20px;
            width: 100%;
        }
        .navbar-brand img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand .logo {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }
        .navbar-brand .brand-name {
            font-size: 2rem;
            font-weight: bold;
            margin-right: 20px;
            color: #fe5b29;
        }
        .navbar-nav .nav-link {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
    <h4>Admin Dashboard</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Home </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user_approve') }}">User Verification</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.showcars')}}">Cars</a>
        </li>
      <li class="nav-item">
            <a class="nav-link" href="{{route('admin.meetings')}}">Meetings</a>
        </li>

    </ul>
</div>

<!-- Content -->
<div class="content">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{route('admin.dashboard')}}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Car Deals Logo" class="logo">
            <span class="brand-name">Car Deals</span>
        </a>
        <div class="collapse navbar-collapse" style="margin-left: 80px; font-weight: bold;">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.dashboard')}}"> Dashboard </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        @yield('content')
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
