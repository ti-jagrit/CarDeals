<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'seller_id',
        'requested_by_id',
        'status',
        'description',
        'rejection_details',
        'meeting_date',
        'visibility',
    ];
    protected $casts = [
        'meeting_date' => 'datetime',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by_id');
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($meeting) {
            // Convert meeting_date to a Carbon instance if it's not already
            $meetingDate = \Carbon\Carbon::parse($meeting->meeting_date);
            $meeting->visibility = $meetingDate->isFuture();
        });
    }


}

