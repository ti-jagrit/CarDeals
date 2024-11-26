<?php

// app/Http/Controllers/MeetingController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\MeetingRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{

    //show all meeting of loggin user
    public function index()
    {
        $userId = auth()->id();

        // Fetch meetings where the user is either the seller or the requester
        $meetings = MeetingRequest::where(function ($query) use ($userId) {
            $query->where('seller_id', $userId)
                ->orWhere('requested_by_id', $userId);
        })->get();

        return view('meeting/meetingInfo', ['meetings' => $meetings]);
    }


  //meeting from
    public function showRequestFrom($id)
    {
        $car = Car::findOrFail($id);
        return view('meeting.meettingrequest', compact('car'));
    }


    public function requestMeeting(Request $request, Car $car)
    {
        $request->validate([
            'description' => 'nullable|string|max:500',
            'meeting_date' => 'required|date|after:today|before_or_equal:' . Carbon::now()->addMonths(3)->toDateString(),
        ]);

        $meetingRequest = new MeetingRequest();
        $meetingRequest->car_id = $car->id;
        $meetingRequest->seller_id = $car->user_id; // Assuming car has a user_id for seller
        $meetingRequest->requested_by_id = auth()->id(); // Assuming the user is logged in
        $meetingRequest->status = 'Pending';
        $meetingRequest->description = $request->description;
        $meetingRequest->meeting_date = $request->meeting_date;
        $meetingRequest->save();

       /* $carOwner = User::find($car->user_id);
        $carOwner->notifications()->create([
            'message' => 'You have a new meeting request for your car.',
            'link' => route('cars.showMeeting', $meetingRequest->id), // Assuming a route to view the meeting
        ]);*/

        return redirect()->route('car.details',['id'=>$car->id])->with('success', 'Meeting request sent successfully!');
    }
    // Approve a meeting request
    public function approve($id)
    {
        $meeting = MeetingRequest::findOrFail($id);

        // Ensure that only the car owner can approve the meeting
        if (Auth::id() !== $meeting->seller_id) {
            return redirect()->back()->with('error', 'You are not authorized to approve this meeting.');
        }

        // Approve the meeting
        $meeting->status = 'Approved';
        $meeting->save();

        return redirect()->back()->with('success', 'Meeting has been approved.');
    }

    // Decline a meeting request
    public function decline(Request $request, $id)
    {
        $request->validate([
            'rejection_details' => 'required|string|max:500',
        ]);

        $meeting = MeetingRequest::findOrFail($id);

        // Ensure that only the car owner can decline the meeting
        if (Auth::id() !== $meeting->seller_id) {
            return redirect()->back()->with('error', 'You are not authorized to decline this meeting.');
        }

        // Decline the meeting and add rejection details
        $meeting->status = 'Rejected';
        $meeting->rejection_details = $request->input('rejection_details');
        $meeting->save();

        return redirect()->back()->with('success', 'Meeting has been declined.');
    }
    public function destroy($id)
    {
        $meeting = MeetingRequest::findOrFail($id);

        // Optionally, you can add checks to ensure only authorized users can delete the meeting

        $meeting->delete();

        return redirect()->back()->with('success', 'Meeting request has been deleted.');
    }


}


