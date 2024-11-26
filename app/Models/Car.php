<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand', 'model', 'make_year', 'fuel_type', 'cc', 'mileage', 'predicted_price',
        'price', 'run_distance', 'location', 'contact', 'description', 'user_id', 'is_sold',
        'Seats', 'Transmission', 'Owner_Type', 'Power',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
