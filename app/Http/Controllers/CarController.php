<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Http\Controllers\RecommendationService;
use Illuminate\Support\Facades\Http;


class CarController extends Controller
{
    //copy code
    public function index()
    {
        // Fetch cars added by the logged-in user
        $cars = Car::where('user_id', auth()->id())->get();

        return view('car/sellcars', compact('cars'));
    }
    public function create(){
        return view('car/add');
    }

    public function showcars(Request $request)
    {
        $query = Car::where('user_id', '!=', auth()->id());
    
        // Apply date sorting
        if ($request->has('date_sort')) {
            if ($request->input('date_sort') == 'recent') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->input('date_sort') == 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        }
    
        // Apply price sorting
        if ($request->has('price_sort')) {
            if ($request->input('price_sort') == 'low_to_high') {
                $query->orderBy('price', 'asc');
            } elseif ($request->input('price_sort') == 'high_to_low') {
                $query->orderBy('price', 'desc');
            }
        }
    
        $cars = $query->get();
    
        return view('car.product', compact('cars'));
    }
    

    // public function showcars()
    // {
    //     // Fetch cars added by the logged-in user
    //     $cars = Car::where('user_id','!=', auth()->id())->get();

    //     return view('car.product', compact('cars'));
    // }



//for multi pages car
    public function createStep1()
{
    return view('car/addcar');  // Load the form for car details
}

public function createStep2()
{
    return view('car/addcarprice');  // Load the form for price, photos, and contact
}
public function storeStep1(Request $request)
{
    $request->validate([
        'brand' => 'required',
        'model' => 'required|regex:/^[\pL\s]+$/u|max:50',
        'make_year' => 'required|integer|date_format:Y|before_or_equal:today|after_or_equal:'.now()->subYears(25)->format('Y'),
        'fuel_type' => 'required',
        'cc' => 'required|integer|min:800|max:10000',
        'mileage' => 'required|numeric|min:1',
        'run_distance' => 'required|integer|min:0',
        'Seats' => 'required|integer|min:2|max:18',
        'Transmission' => 'required',
        'Owner_Type' => 'required',
        'Power' => 'required|numeric|min:20|max:2000',
    ]);

    // Store car details in the session
    session()->put('car_details', $request->all());

    // Get the predicted price
    $predictedPrice = $this->predictPrice($request);

    // Store the predicted price in the session
    session()->put('predicted_price', $predictedPrice);

    // Redirect to the second step
    return redirect()->route('cars.createStep2');
}

public function storeStep2(Request $request)
{
    $request->validate([
        'price' => 'required|numeric|min:100000',
        'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
        'contact' => 'required|digits:10|regex:/^98\d{8}$/',
             
    ]);

    // Get predicted price from session
    $predictedPrice = session('predicted_price');
    $predictedPrice = $predictedPrice*100000;
  
    // Retrieve car details from session
    $carDetails = session('car_details');

    // Save the car
    $car = Car::create(array_merge($carDetails, [
        'price' => $request->price,
        'contact' => $request->contact,
        'user_id' => auth()->id(),
        'predicted_price' => $predictedPrice,
    ]));

    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $photoPath = $photo->store('carphotos', 'public');
            $car->photos()->create(['path' => $photoPath]);
        }
    }

    return redirect()->route('cars.index')->with('success', 'Car added successfully!');
}


public function carpredictPrice(Request $request)
{
    // Validate the request
    $request->validate([
        'make_year' => 'required|integer|date_format:Y|before_or_equal:today|after_or_equal:'.now()->subYears(25)->format('Y'),
        'fuel_type' => 'required|alpha_num|max:20',
        'cc' => 'required|integer|min:800|max:10000',
        'mileage' => 'required|numeric|min:0',
        'run_distance' => 'required|integer|min:0',
        'seats' => 'required|integer|min:2|max:18',
        'transmission' => 'required|in:Manual,Automatic',
        'owner_type' => 'required|in:First,Second,Third',
        'power' => 'required|numeric|min:20|max:2000',
        
    ]);

    // Use the predictPrice function you've already written to get the predicted price
    $predictedPrice = $this->predictPrice($request);
    $predictedPrice=$predictedPrice*100000;
    
    if ($predictedPrice) {
        $minPrice = $predictedPrice - 50000;
    $maxPrice = $predictedPrice + 50000;

    $cars = Car::where('price', '>=', $minPrice)
                ->where('price', '<=', $maxPrice)
                ->where('is_sold', false)
                ->get();

    return view('car.predict_price', compact('cars', 'predictedPrice'));
        // return view('car.predict_price', ['predictedPrice' => $predictedPrice]);
    }

    return back()->withErrors('Unable to predict price. Please try again.');
}







    public function store(Request $request)
    {
        
        $request->validate([
                  'brand' => 'required|alpha_num|max:50',
        'model' => 'required|regex:/^[\pL\s]+$/u|max:50',
        'make_year' => 'required|integer|date_format:Y|before_or_equal:today|after_or_equal:'.now()->subYears(25)->format('Y'),
        'fuel_type' => 'required|alpha_num|max:20',
        'cc' => 'required|integer|min:800|max:10000',
        'mileage' => 'required|numeric|min:0',
        'predicted_price' => 'nullable|numeric',
        'price' => 'required|numeric|min:100000',
        'run_distance' => 'required|integer|min:0',
        'location' => 'required|regex:/^[\pL\s]+$/u|max:100',
        'contact' => 'required|digits:10|regex:/^98\d{8}$/',
        'description' => 'nullable|regex:/^[\pL\s]+$/u|max:255',
        'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
        'seats' => 'required|integer|min:2|max:18',
        'transmission' => 'required|in:Manual,Automatic',
        'owner_type' => 'required|in:First,Second,Third',
        'power' => 'required|numeric|min:50|max:2000',
           
        ]);

        // Get the predicted price
        $predictedPrice = $this->predictPrice($request);

        $car = Car::create([
            'brand' => $request->brand,
            'model' => $request->model,
            'make_year' => $request->make_year,
            'fuel_type' => $request->fuel_type,
            'cc' => $request->cc,
            'price' => $request->price,
            'mileage' => $request->mileage,
            'predicted_price' => $predictedPrice,
            'run_distance' => $request->run_distance,
            'location' => $request->location,
            'contact' => $request->contact,
            'description' => $request->description,
            'Seats' => $request->seats,
            'Transmission' => $request->transmission,
            'Owner_Type' => $request->owner_type,
            'power' => $request->power,
            'user_id' => auth()->id()
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPath = $photo->store('carphotos', 'public');
                $car->photos()->create(['path' => $photoPath]);
            }
        }

        return redirect()->route('cars.index')->with('success', 'Car added successfully!');
    }

    private function predictPrice(Request $request)
    {
        // Format data according to Flask API requirements
        $data = [
            'Year' => (float)$request->make_year,
            'Kilometers_Driven' => (float)$request->run_distance, // Assuming run_distance maps to Kilometers_Driven
            'Mileage' => (float)$request->mileage,
            'Engine' => (float)$request->cc,
            'Power' => (float)$request->power,
            'Seats' => (float)$request->seats,
            'Fuel_Type_Diesel' => $request->fuel_type === 'Diesel' ? 1 : 0,
            'Fuel_Type_Petrol' => $request->fuel_type === 'Petrol' ? 1 : 0,
            'Transmission_Manual' => $request->transmission === 'Manual' ? 1 : 0,
            'Transmission_Automatic' => $request->transmission === 'Automatic' ? 1 : 0,
            'Owner_Type_First' => $request->owner_type === 'First' ? 1 : 0,
            'Owner_Type_Second' => $request->owner_type === 'Second' ? 1 : 0,
            'Owner_Type_Third' => $request->owner_type === 'Third' ? 1 : 0,
        ];

        // Send request to Flask API
        $response = Http::post('http://127.0.0.1:5000/predict', $data);

        if ($response->successful()) {
            return $response->json()['predicted_price'];
        } else {
            // Handle errors as needed
            return null;
        }
    }


   
    public function showDetails($id)
{
    $car = Car::findOrFail($id);

    // Step 1: Fetch cars matching brand, price range, and not added by the current user
    $recommendedCars = Car::query()
        ->where('id', '!=', $id)
        ->where('user_id', '!=', auth()->id()) // Exclude cars from the current user
        ->where('brand', $car->brand)
        ->whereBetween('price', [$car->price * 0.8, $car->price * 1.2])
        ->take(3)
        ->get();

    // Step 2: If fewer than 3 cars are found, relax by removing the price condition, but keeping the brand
    if ($recommendedCars->count() < 3) {
        $recommendedCars = Car::query()
            ->where('id', '!=', $id)
            ->where('user_id', '!=', auth()->id()) // Exclude cars from the current user
            ->where('brand', $car->brand)
            ->take(3)
            ->get();
    }

    // Step 3: If fewer than 3 cars are found, try matching price range only, ignoring the brand
    if ($recommendedCars->count() < 3) {
        $recommendedCars = Car::query()
            ->where('id', '!=', $id)
            ->where('user_id', '!=', auth()->id()) // Exclude cars from the current user
            ->whereBetween('price', [$car->price * 0.8, $car->price * 1.2])
            ->take(3)
            ->get();
    }


    // Pass the car and recommended cars to the view
    return view('car.productDetails', [
        'car' => $car,
        'recommendedCars' => $recommendedCars
    ]);
}




















    //for details view of car

    public function show(Car $car)
    {
        return view('car.SarDetailsSeller', compact('car'));
    }
//to show car deailt in buyer
    public function showDeatils($id)
    {
        $car = Car::with('photos')->findOrFail($id); // Assuming you have a Car model and a photos relationship

        return view('car/productDetails', compact('car'));
    }

    //to edit car

    public function edit(Car $car)
    {
        return view('car.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'brand' => 'required|alpha_num|max:50',
            'model' => 'required|regex:/^[\pL\s]+$/u|max:50',
            'make_year' => 'required|integer|date_format:Y|before_or_equal:today|after_or_equal:'.now()->subYears(25)->format('Y'),
            'fuel_type' => 'required|alpha_num|max:20',
            'cc' => 'required|integer|min:800|max:10000', // Adjust max limit as needed
            'mileage' => 'nullable|numeric|min:0',
            'predicted_price' => 'nullable|numeric',
            'run_distance' => 'required|integer|min:0',
            'location' => 'required|regex:/^[\pL\s]+$/u|max:100',
            'contact' => 'required|digits:10|regex:/^98\d{8}$/',
            'description' => 'nullable|regex:/^[\pL\s]+$/u|max:255',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:4048'
        ]);

        // Update the car details
        $car->update($request->except('photos'));

        // Handle photo uploads if any
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('public/photos');
                $car->photos()->create(['path' => basename($path)]);
            }
        }

        return redirect()->route('cars.show', $car->id)->with('success', 'Car updated successfully');
    }



    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Car deleted successfully');
    }

    public function markAsSold(Car $car)
    {
        $car->is_sold = true;
        $car->save();
        return redirect()->route('cars.index', $car->id)->with('success', 'Car marked as sold');
    }

    //to seach car
    



    public function ShowindexPage()
    {
       
        $cars = Car::where('is_sold', false)->latest()->take(9)->get();
    
        // Pass the cars to the view
        return view('index', compact('cars'));
    }
    


     



}
