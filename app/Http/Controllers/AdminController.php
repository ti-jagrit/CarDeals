<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\MeetingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function index()
    {
        // Total number of cars
        $totalCars = Car::count();

        // Total number of users
        $totalUsers = User::count();

        // Total number of meetings
        $totalMeetings = MeetingRequest::count();

        // Average price of cars
        $averagePrice = Car::avg('price');

        // Meetings per year
        $meetingsPerYear = MeetingRequest::select(DB::raw('YEAR(meeting_date) as year'), DB::raw('COUNT(*) as count'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return view('admin/admindashinfo', compact('totalCars', 'totalUsers', 'totalMeetings', 'averagePrice', 'meetingsPerYear'));
    }

    public function VerifyUserRequest()
    {
        $datas = User::where('isvarified', '0')->get();
        return view('admin.userApprove', compact('datas'));
    }
    public function approveUser($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if ($user) {
            // Update the isVerified column
            $user->	isvarified = 1;
            $user->save();
        }

        return redirect()->back()->with('success', 'User approved successfully!');
    }

    public function rejectUser($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if ($user) {
            // Delete the user
            $user->delete();
        }

        return redirect()->back()->with('success', 'User rejected and deleted successfully!');
    }

    public function showCarRequests()
    {
        $cars = Car::with('user') // Assuming 'user' is the relationship name for the seller
        ->select('id', 'brand', 'model', 'price', 'make_year', 'location', 'contact', 'predicted_price', 'user_id')
            ->get();

        return view('admin/Admincars', compact('cars'));
    }

    public function deleteCar($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.showcars')->with('success', 'Car deleted successfully');
    }
    public function showMeetingRequests()
    {
        $meetings = MeetingRequest::with(['car', 'seller'])
            ->get();

        return view('admin/adminmeetings', compact('meetings'));
    }


}
