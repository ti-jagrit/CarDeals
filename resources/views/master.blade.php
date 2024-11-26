{{--<h2> This is dashBoard {{\Illuminate\Support\Facades\Auth::user()->name}}</h2>
{{\Illuminate\Support\Facades\Auth::user()}}
<a href="{{route('logout')}}" class="btn btn-danger">Logout </a>
--}}
    <!DOCTYPE html>
<html>
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Car Deals</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <!-- Responsive-->
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <!-- fevicon -->
    <link rel="icon" href="{{asset('assets/images/logo.png')}}" type="image/x-icon" />

    <!-- font css -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/jquery.mCustomScrollbar.min.css')}}}">
    <!-- Tweaks for older IEs-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl1k3p4KJ2jF6Bq3JcJ8W9cfug2FLg3py4qSC24JofrY8FHP6fpD0Ph7j8" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgYPik3IuwHwF8UlKuo8L5Zo4ONf0Rr1G5d1S6kP6AR3U7KzZsU" crossorigin="anonymous"></script>
    <style>
        #navbar a{

            font-weight: bold;
            font-size: 20pt;
        }
        #navbar a:hover{
            color:#fe5b29;
        }

        #icone_user a{
            color: #fe5b29;
            font-weight: normal;

        }
        #icone_user a:hover{
            color: white;
            background-color: #fe5b29;

        }
        #notification a{
            color: rgb(23, 22, 22);
            font-size: 20px;
            font-weight: normal;

        }
        #notification a:hover{
            color: black;
            background-color: rgb(215, 214, 214);

        }
        /* Fixed size for car card */
        /* Fixed size for car card with new design */
        .car-card {
            border: 2px solid #fe5b29; /* Border color */
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff; /* Card background color */
            max-width: 300px;
            margin: auto;
        }

        .car-card img {
            width: 100%;
            height: 200px; /* Fixed height for image */
            object-fit: cover;
        }

        .car-card .card-body {
            padding: 15px;
            text-align: center;
        }

        .car-card .card-title {
            font-size: 1.2rem;
            color: #fe5b29; /* Title color */
            margin-bottom: 10px;
        }

        .car-card .card-text {
            color: royalblue; /* Text color */
            font-size: 0.9rem;
        }

        .car-card .card-footer {
            background-color: #fe5b29; /* Footer color */
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 0.9rem;
        }

        .car-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }



    </style>
</head>
<body>
<!-- header section start -->
<div class="header_section" style="background-color:rgb(7, 7, 7); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container" >
        <nav class="navbar navbar-expand-lg" id="navbar">
            <a class="navbar-brand" href="index.html">
                <img style="height: 70px;" src="{{asset('assets/images/logo.png')}}" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto" id="list" style="font-weight: normal;">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('homePage')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('cars.show')}}">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('cars.index')}}">Sell Car</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    {{-- <li class="nav-item dropdown" style="margin-left: 50px; margin-right: 10px;">
                        <a class="nav-link" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown" id="notification">
                            <a class="dropdown-item" href="#">Notification 1</a>
                            <a class="dropdown-item" href="#">Notification 2</a>
                            <a class="dropdown-item" href="#">Notification 3</a>
                        </div>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" style="height: 60px; width: 60px; overflow: hidden; border-radius: 50%;" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" style="border-radius: 50%; width: 100%; height: auto;" alt="User">
{{--                            <img src="{{asset('storage/photos/foI9SNoTPiSjv2lXS5uq6XgGaDxYVRV2bgxaKlIv.jpg')}}"  style="border-radius:50% " alt="User">--}}
                        </a>
{{--                        --}}
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown" id="icone_user">
                            <a class="dropdown-item" href="{{route('user.profile')}}">{{auth()->user()->name}}</a>
                            <a class="dropdown-item" href="{{route('user.profile')}}">Settings</a>
                            <a class="dropdown-item" href="{{route('meetings.index')}}">Meetings</a>
                            <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                </form>
            </div>
        </nav>
    </div>
</div>
<!-- header section end -->




<div class="call_text_main">
    <div class="container">
        <div class="call_taital">

            <div class="call_text" style="color: white; font-size: 13pt;"><span class="padding_left_15"></span></div>

        </div>
    </div>
</div>






<div class="about_section layout_padding" >
   @yield('body')
</div>



<div class="footer_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footeer_logo"><img src="{{asset('assets/images/logo.png')}}" style="width: 300px;"></div>
            </div>
        </div>
        <div class="footer_section_2">
            <div class="row">
                <div class="col" style="text-align: center;">
                    <h4 class="footer_taital">Check Now</h4>
                    <p class="footer_text">There are many variations of passages of Lorem Ipsum available,</p>
                </div>
            </div>
        </div>
    </div>
    <!-- footer section end -->
    <!-- copyright section start -->
    <div class="copyright_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <p class="copyright_text">2023 All Rights Reserved to car Deals</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('assets/js/plugin.js')}}"></script>
<!-- sidebar -->
<script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl1k3p4KJ2jF6Bq3JcJ8W9cfug2FLg3py4qSC24JofrY8FHP6fpD0Ph7j8" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgYPik3IuwHwF8UlKuo8L5Zo4ONf0Rr1G5d1S6kP6AR3U7KzZsU" crossorigin="anonymous"></script>
    <!-- FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
