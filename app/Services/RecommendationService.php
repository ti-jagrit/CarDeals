<?php

namespace App\Services;

use App\Models\Car;

class RecommendationService
{
    // /**
    //  * Get recommended cars based on similarity.
    //  *
    //  * @param Car $car
    //  * @return \Illuminate\Database\Eloquent\Collection
    //  */
    // public function recommendSimilarCars(Car $car)
    // {
    //     // Set the price range for recommendations (±20% of the car's price)
    //     $minPrice = $car->price * 0.8;
    //     $maxPrice = $car->price * 1.2;

    //     // Fetch cars with similar brand, price within the range, and make year
    //     return Car::where('brand', $car->brand)
    //         ->whereBetween('price', [$minPrice, $maxPrice])
    //         ->where('make_year', $car->make_year)
    //         ->where('fuel_type', $car->fuel_type)
    //         ->where('id', '!=', $car->id)  // Exclude the current car from the results
    //         ->orderBy('created_at', 'desc')
    //         ->take(3)  // Limit the number of recommended cars
    //         ->get();
    // }
}
