<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Deals - Discover the Best Car Market</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Body Style */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #0e0d0d;
        }

        /* Top Section */

        .hero_section {
            background-image: url('{{ asset('assets/images/banner-img.png') }}');
            /* Add your background image here */
            background-size: cover;
            /* Ensures the image covers the whole section */
            background-position: center;
            /* Centers the background image */
            background-repeat: no-repeat;
            padding: 50px 20px;
            text-align: center;
            border-bottom: 4px solid #fe5b29;
            /* Adding a modern border at the bottom */
            color: #ffffff;
            /* Ensuring the text stands out on the background */
            position: relative;
        }

        .hero_section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Dark overlay for better text readability */
            z-index: 1;
        }

        .hero_section * {
            position: relative;
            z-index: 2;
            /* Places all content above the overlay */
        }

        .hero_title {
            font-family: 'Poppins', sans-serif;
            font-size: 36px;
            color: #f5f5f5;
            /* Light color for contrast */
            margin-bottom: 10px;
        }

        .hero_title b {
            color: #fe5b29;
            /* Brand orange color */
        }

        .hero_subtitle {
            font-family: 'Raleway', sans-serif;
            font-size: 18px;
            color: #eaeaea;
            margin-bottom: 40px;
        }

        .hero_logo img {
            width: 150px;
            margin-bottom: 20px;
        }







        .feature_highlight {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            /* Makes it responsive */
            gap: 30px;
        }

        .feature_card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 250px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature_card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .feature_card i {
            font-size: 36px;
            color: #fe5b29;
            margin-bottom: 15px;
        }

        .feature_card h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            color: #333;
            margin-bottom: 10px;
        }

        .feature_card p {
            font-family: 'Raleway', sans-serif;
            font-size: 16px;
            color: #666;
        }


        .recent_cars_section {
            background-color: #ffffff;
            padding: 60px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Light shadow for depth */
        }

        .recent_cars_section h2 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
            font-size: 36px;
            font-weight: 700;
            /* Bold text for the title */
        }

        .car_card {
            background-color: #f9f9f9;
            /* Light background for the card */
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Smooth effects */
        }

        .car_card:hover {
            transform: translateY(-5px);
            /* Slight lift effect on hover */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            /* Darker shadow on hover */
        }

        .car_card img {
            width: 100%;
            height: 200px;
            /* Fixed height for uniformity */
            object-fit: cover;
            /* Crop images to fit */
            border-radius: 10px;
            margin-bottom: 15px;
            /* Space between image and title */
        }

        .car_card h3 {
            margin-top: 15px;
            font-size: 20px;
            color: #333;
            font-weight: 600;
            /* Semi-bold text for the car name */
        }

        .car_card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            /* Space between description and button */
        }
        .car_card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .car_card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .car_card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .buy_now_button {
            background-color: #fe5b29;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }

        .buy_now_button:hover {
            background-color: #f06d28;
            transform: scale(1.05);
        }

        .buy_now_button {
            background-color: #fe5b29;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
            /* Smooth effects */
        }

        .buy_now_button:hover {
            background-color: #f06d28;
            /* Darker shade on hover */
            transform: scale(1.05);
            /* Slight grow effect on hover */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .recent_cars_section h2 {
                font-size: 28px;
            }

            .car_card {
                margin-bottom: 20px;
                /* Add spacing for mobile */
            }
        }
        .recent_cars_section {
    margin-top: 30px;
}

.recent_cars_section h2 {
    font-size: 2rem;
    text-align: center;
    font-weight: bold;
    margin-bottom: 30px;
}

.car_card {
    border: 1px solid #ddd;
    border-radius: 10px;
    transition: transform 0.3s ease;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.car_card:hover {
    transform: scale(1.05);
}

.car_card img {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    height: 200px;
    object-fit: cover;
}

.card-body {
    padding: 15px;
    background-color: #f8f9fa;
}

.card-title {
    font-size: 1.3rem;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin-bottom: 10px;
}

.card-text {
    font-size: 1rem;
    color: #555;
    line-height: 1.6;
}

.card-text strong {
    color: #000;
}

.card-text .predicted-price {
    font-weight: bold;
    color: #28a745; /* green for predicted price */
}

.card-text span {
    display: block;
    margin-bottom: 5px;
}

.car_card a {
    text-decoration: none;
    color: inherit;
}

@media (max-width: 768px) {
    .car_card {
        margin-bottom: 20px;
    }
}



        /* Footer Section */
        .footer_section {
            background-color: #1a1818;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer_section img {
            width: 150px;
            margin-bottom: 20px;
        }

        .footer_buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .footer_buttons a {
            background-color: white;
            color: #fe5b29;
            padding: 15px 30px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .footer_buttons a:hover {
            background-color: #fe5b29;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero_section h1 {
                font-size: 36px;
            }

            .feature_highlight {
                flex-direction: column;
            }

            .recent_cars_section h2 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

    <!-- Hero Section Start -->
    <div class="hero_section">
        <div class="hero_logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="CarDeals Logo">
        </div>
        <h1 class="hero_title">Welcome to <b>CarDeals!</b></h1>
        <p class="hero_subtitle">Explore amazing car deals and market insights all in one place.</p>

        <div class="feature_highlight">
            <div class="feature_card">
                <i class="fas fa-car"></i>
                <h3>Wide Car Selection</h3>
                <p>Choose from a variety of top models and brands.</p>
            </div>
            <div class="feature_card">
                <i class="fas fa-dollar-sign"></i>
                <h3>Best Deals</h3>
                <p>Get the most competitive prices in the market.</p>
            </div>
            <div class="feature_card">
                <i class="fas fa-shield-alt"></i>
                <h3>Trusted Sellers</h3>
                <p>Buy with confidence from verified sellers.</p>
            </div>
            <div class="feature_card">
                <i class="fas fa-search"></i>
                <h3>Advanced Search</h3>
                <p>Find the car that fits your needs with ease.</p>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Recently Added Cars Section Start -->
    
    <div class="recent_cars_section">
        <h2>Recently Added Cars</h2>
        <div class="container">
            <div class="row">
            
                @forelse ($cars as $car)

                    @if (!$car->is_sold)
                        <div class="col-md-4 mb-4">
                            <a href="{{ route('car.details', $car->id) }}" class="text-decoration-none">
                                <div class="card car_card">
                                    <!-- Check if the car has photos -->
                                    @if ($car->photos->isNotEmpty())
                                        <img src="{{ asset('storage/' . $car->photos->first()->path) }}"
                                            class="card-img-top" alt="Car Photo">
                                    @else
                                        <!-- Placeholder image if no photos are available -->
                                        <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top" alt="Placeholder">
                                    @endif

                                    <div class="card-body">
                                        <!-- Car Details -->
                                        <h5 class="card-title" style="color: #f06d28">{{ $car->brand }} - {{ $car->model }}</h5>
                                        <p class="card-text">
                                            <strong>Run Distance:</strong> {{ $car->run_distance }} km<br>
                                            <strong>Price:</strong> {{ number_format($car->price) }}<br>
                                            <strong>Location:</strong> {{ $car->location }}<br>
                                            <strong>Make Year:</strong> {{ $car->make_year }}<br>

                                            <!-- Predicted Price (if available) -->
                                            {{-- @if ($car->predicted_price != null)
                                                <strong style="color:green;">Predicted Price:</strong>
                                                {{ $car->predicted_price }} Lakhs
                                            @endif --}}
                                        </p>
                                    </div>

                                   
                                </div>
                            </a>
                        </div>
                    @endif
                @empty
                    
                @endforelse
            </div>
        </div>
    </div>
    <!-- Recently Added Cars Section End -->

    

    <!-- Footer Section Start -->
    <div class="footer_section">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Car Deals Logo">
        <div class="footer_buttons">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        </div>
    </div>
    <!-- Footer Section End -->

    <!-- Javascript -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
