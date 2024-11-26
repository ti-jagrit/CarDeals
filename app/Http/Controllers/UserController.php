<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user=\auth()->user();
        return view('frontend/user_profile',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|regex:/^[\pL\s]+$/u',
            'email' => 'required|email|unique:users,email', // Proper email format
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[@$!%*?&#]/' // At least one special character
            ],
            'password_confirmation' => 'required|same:password',
            'citizenship' => [
                'required',
                'regex:/^[0-9\/\-]+$/', // Only numbers, slashes, and dashes allowed
            ],
            'phone' => [
                'required',
                'numeric',
                'digits:10',
                'regex:/^98\d{8}$/' // Must be a 10-digit number starting with 98
            ],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Image file validation
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        // Hash the password
        $data['password'] = bcrypt($data['password']);

        // Create the user
        $user = User::create($data);

        if ($user) {
            return redirect()->route('login')->with('success','User Registred waiting for admin approval');
        }

        return back()->with('error', 'Registration failed');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|regex:/^[\pL\s]+$/u|max:255', // Name must be letters and spaces only
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Unique email for current user
            'phone' => [
                'required',
                'numeric',
                'digits:10',
                'regex:/^98\d{8}$/' // Must be a 10-digit number starting with 98
            ],
            'citizenship' => [
                'required',
                'regex:/^[0-9\/\-]+$/', // Only numbers, slashes, and dashes allowed
                'max:50'
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'

        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->citizenship = $request->citizenship;

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete('public/photos/' . $user->photo);
            }
            $user->photo = $request->file('photo')->store('photos', 'public');
        }


        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    // Change the password
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation'=>'required|same:new_password',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('user.profile')->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Password changed successfully.');
    }

    // Delete the account
    public function deleteAccount($id)
    {
        $user = Auth::user();

        // Delete all cars associated with the user
        $user->cars()->each(function ($car) {
            // Delete car photos
            if ($car->photos) {
                foreach ($car->photos as $photo) {
                    Storage::delete('public/' . $photo->path);
                }
            }
            // Delete the car record
            $car->delete();
        });

        // Delete the user's photo
        if ($user->photo) {
            Storage::delete('public/' . $user->photo);
        }

        // Delete the user
        $user->delete();

        return redirect('/')->with('success', 'Account and all associated cars deleted successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Auth::logout();
        return redirect()->route('index');
    }



   
    public function login(Request $request)
{
    $pdata = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($pdata)) {
        $user = Auth::user();
        
        // Redirect based on user role
        if ($user->isAdmin == '1') {
            return redirect()->route('admin.dashboard');    
        } else {
            // Check if the user is verified
            if ($user->isvarified == '1') {
                // Retrieve intended URL or set default
                $intendedUrl = session('url.intended', route('homePage')); // Default to homePage
                session()->forget('url.intended'); // Clear intended URL
                
                return redirect()->to($intendedUrl)->with('user', $user);
            } else {
                return redirect()->route('login')
                    ->withErrors(['message' => 'Your account is not verified yet.'])
                    ->withInput();
            }
        }
    } else {
        return redirect()->route('login')
            ->withErrors(['message' => 'Username or password incorrect.'])
            ->withInput();
    }
}

public function homePage() {
    if (Auth::check()) {
        $user = Auth::user();
        
        // Fetch recent cars and low-priced cars
        $recentCars = Car::orderBy('created_at', 'desc')->take(6)->get(); // Get the 6 most recent cars
        $lowPriceCars = Car::orderBy('price', 'asc')->take(6)->get(); // Get the 6 lowest priced cars

        // Pass data to the view
        return view('frontend/home', compact('user', 'recentCars', 'lowPriceCars'));
    } else {
        return redirect()->route('login');
    }
}

   
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    
}
