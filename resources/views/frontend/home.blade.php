@extends('master')

<style>
/* General Font and Body Styling */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f9f9f9;
    color: #333;
}

h1, h3 {
    font-weight: 700;
}

p {
    font-size: 14px;
    line-height: 1.6;
}

/* Banner Section */
.banner_section {
    background: url('{{asset('assets/images/banner-bg.jpg')}}') no-repeat center center/cover;
    padding: 60px 0;
}

.banner_taital {
    font-size: 45px;
    line-height: 1.2;
    color: #ffffff;
}

.contact_bt a {
    background-color: #fe5b29;
    color: #fff;
    padding: 12px 30px;
    border-radius: 30px;
    text-transform: uppercase;
    transition: background 0.3s ease-in-out;
}

.contact_bt a:hover {
    background-color: #333;
}

/* Gallery Section */
.gallery_section {
    background-color: #fff;
    padding: 80px 0;
}

.gallery_box {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 30px;
    transition: transform 0.3s ease-in-out;
    text-align: center;
    cursor: pointer;
}

.gallery_box:hover {
    transform: translateY(-10px);
}

.gallery_img img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
}

.types_text {
    font-size: 20px;
    font-weight: 600;
    margin-top: 15px;
}

.read_bt a {
    background-color: #fe5b29;
    color: #fff;
    padding: 10px 20px;
    border-radius: 20px;
    display: inline-block;
    transition: background-color 0.3s;
}

.read_bt a:hover {
    background-color: #333;
}

/* Grid Layout for Product Display */
.gallery_section_2 {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}
.body_text{
    font-size: 12pt;
    font-weight: bold;
    color: royalblue;
}

</style>

@section('body')

<!-- banner section start -->
<div class="banner_section " style="margin-top:-90px; ">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="banner_slider" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="banner_taital_main">
                                <h1 class="banner_taital">Best Car Deals <br><span style="color: #fe5b29;">For You</span></h1>
                                <p class="banner_text">There is something you needed the most..</p>
                                <div class="btn_main">
                                    <div class="contact_bt active"><a href="{{route('cars.show')}}">Check now</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="banner_taital_main">
                                <h1 class="banner_taital">Sell Your <br><span style="color: #fe5b29;">Car!!</span></h1>
                                <p class="banner_text">Get Best Deal..</p>
                                <div class="btn_main">
                                    <div class="contact_bt"><a href="{{ route('cars.create') }}">Add Yours</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="banner_taital_main">
                                <h1 class="banner_taital">We are <br><span style="color: #fe5b29;">For You</span></h1>
                                <p class="banner_text">Car in Your budget</p>
                                <div class="btn_main">
                                    <div class="contact_bt"><a href="#">Read More</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#banner_slider" role="button" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#banner_slider" role="button" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="banner_img"><img src="{{ asset('assets/images/banner-img.png') }}"></div>
            </div>
        </div>
    </div>
</div>
<!-- banner section end -->

<!-- gallery section start -->
<div class="gallery_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="gallery_taital">Our Best Offers</h1>
            </div>
        </div>
        <div class="gallery_section_2">
            <!-- Low Price Products Section -->
            @foreach ($lowPriceCars as $car)
            <div class="gallery_box">
                <a href="{{ route('car.details', $car->id) }}" class="text-decoration-none">
                    <div class="gallery_img">
                        @if($car->photos->isNotEmpty())
                            <img src="{{ asset('storage/' . $car->photos->first()->path) }}" alt="{{ $car->name }}">
                        @else
                            <img src="{{ asset('images/placeholder.jpg') }}" alt="No Image Available">
                        @endif
                    </div>
                    <h3 class="types_text">{{ $car->brand }} - {{ $car->model }}</h3>
                 <b>   <p class="body_text">Year: {{ ($car->make_year) }} </p>
                    <p class="body_text">Price: {{ number_format($car->price) }} </p></b>
                    <div >
                        <a href="{{ route('car.details', $car->id) }}" class="btn btn-danger">Buy Now</a>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="search_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="text-align: center;">
                        <h1 class="search_taital">Recent Cars</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="gallery_section_2">
            <!-- Recent Products Section -->
            @foreach ($recentCars as $car)
            <div class="gallery_box">
                <a href="{{ route('car.details', $car->id) }}" class="text-decoration-none">
                    <div class="gallery_img">
                        @if($car->photos->isNotEmpty())
                            <img src="{{ asset('storage/' . $car->photos->first()->path) }}" alt="{{ $car->name }}">
                        @else
                            <img src="{{ asset('images/placeholder.jpg') }}" alt="No Image Available">
                        @endif
                    </div>
                    <h3 class="types_text">{{ $car->brand }} - {{ $car->model }}</h3>
                 <b>   <p class="body_text">Year: {{ number_format($car->make_year) }} </p>
                    <p class="body_text">Price: {{ number_format($car->price) }} </p></b>
                    <div >
                        <a href="{{ route('car.details', $car->id) }}" class="btn btn-danger">Buy Now</a>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

       
    </div>
</div>
<!-- gallery section end -->

<!-- about section start -->
<div class="about_section layout_padding">
    <div class="container">
        <div class="about_section_2">
            <div class="row">
                <div class="col-md-6">
                    <div class="image_iman"><img src="{{ asset('assets/images/about-img.png') }}" class="about_img"></div>
                </div>
                <div class="col-md-6">
                    <div class="about_taital_box">
                        <h1 class="about_taital">About <span style="color: #fe5b29;">Us</span></h1>
                        <p class="about_text" style="font-size: 13pt; text-align: justify; color: black;">Welcome to Car Deals, the ultimate platform for buying and selling cars...</p>
                        <div class="readmore_btn"><a href="#">Read More</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about section end -->

@endsection
