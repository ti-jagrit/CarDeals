<?php

use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

route::get('/', function () {    return view('index');})->name('index');
Route::get('/registeration', function () {
    return view('frontend/register');
})->name('register');
Route::get('/login', function () {
    return view('frontend/login');
})->name('login');

Route::get('/admin', function () {
    return view('admin/adminDash');
})->name('admin');

//for login
Route::post('loginMatch',[UserController::class,'login'])->name('loginMatch');
Route::post('userreg',[UserController::class,'store'])->name('user_registration');



Route::group(['middleware' => 'auth.check'], function () {

Route::get('/admin/user-approve', [AdminController::class, 'VerifyUserRequest'])->name('user_approve');
//approve and reject user from admin pannel
Route::post('/user/approve/{id}',[AdminController::class,'approveUser'])->name('user.approve');
Route::post('/user/reject/{id}',[AdminController::class,'rejectUser'])->name('user.reject');
//delete car by admin
// Route to show car
Route::get('/admin/cars', [AdminController::class, 'showCarRequests'])->name('admin.showcars');
// Route to delete a car
Route::delete('/admin/car/{id}', [AdminController::class, 'deleteCar'])->name('admin.car.delete');
//for all the meeting information
Route::get('/meeting-requests', [AdminController::class, 'showMeetingRequests'])->name('admin.meetings');
//show system information
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');




//for redirect to homepage
Route::get('home',[UserController::class,'homePage'])->name('homePage');
//for logout
Route::get('logout',[UserController::class,'logout'])->name('logout');



//for show deatils in userprofile
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::put('/user/change-password/{id}', [UserController::class, 'changePassword'])->name('user.changePassword');
Route::delete('/user/delete/{id}', [UserController::class, 'deleteAccount'])->name('user.delete');
Route::get('/user/profile',[UserController::class,'index'])->name('user.profile');

//car to buyer
Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
Route::get('/seller/my-cars', [CarController::class, 'index'])->name('cars.index');
Route::post('/cars', [CarController::class, 'store'])->name('cars.store');


//car to seller
Route::get('/seller/cars-details/{car}', [CarController::class, 'show'])->name('cars.details.show');
Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
Route::delete('cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
Route::post('cars/{car}/mark-as-sold', [CarController::class, 'markAsSold'])->name('cars.markAsSold');
//for multi pages from of cars
Route::get('/cars/create/step1', [CarController::class, 'createStep1'])->name('cars.createStep1');
Route::post('/cars/store/step1', [CarController::class, 'storeStep1'])->name('cars.storeStep1');
// Step 2: Price, Photos, and Contact
Route::get('/cars/create/step2', [CarController::class, 'createStep2'])->name('cars.createStep2');
Route::post('/cars/store/step2', [CarController::class, 'storeStep2'])->name('cars.storeStep2');



//for buyer car details view
Route::get('/car-details/{id}', [CarController::class, 'showDeatils'])->name('car.details');
//for prodcuct page view
Route::get('/cars-list', [CarController::class, 'showcars'])->name('cars.show');




//for search car
Route::get('/cars/search', [CarController::class, 'showSearchForm'])->name('cars.searchForm');
Route::get('/cars/search/results', [CarController::class, 'searchResults'])->name('cars.searchResults');




//to delete photo
// In your web.php
Route::delete('photos/{photo}', [\App\Http\Controllers\PhotoController::class, 'destroy'])->name('photos.destroy');




//price predict
Route::post('/predict-price', [CarController::class, 'predictPrice'])->name('predict.price');


//for meeting showing from and store in databse
Route::post('/cars/{car}/request-meeting', [MeetingController::class, 'requestMeeting'])->name('cars.requestMeeting');

Route::get('/cars/{id}/meeting-request', [MeetingController::class, 'showRequestFrom'])->name('cars.showMeetingForm');



//for paymnet page khalti
// Route::get('/cars/{id}/pay', [PaymentController::class, 'showPayment'])->name('cars.showPayment');
Route::POST('/cars/{id}/pay', [PaymentController::class, 'showPayment'])->name('cars.showPayment');
Route::post('/payment/verify', [PaymentController::class, 'verifyPayment'])->name('payment.verify');





// Route to list all meetings for the logged-in user
Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index');
//for meeting approve and reject
Route::post('/meetings/{meeting}/approve', [MeetingController::class, 'approve'])->name('meetings.approve');
Route::post('/meetings/{meeting}/decline', [MeetingController::class, 'decline'])->name('meetings.decline');
//if rejected requester can delete meeting request
Route::delete('/meetings/{meeting}', [MeetingController::class, 'destroy'])->name('meetings.destroy');





//Route::get('/cars/{id}', [CarController::class, 'displayCarDetails'])->name('cars.show');
//Route::get('/car-details/{id}', [CarController::class, 'displayCarDetails'])->name('car.details');




//for price prediction of car
Route::post('/predict-price', [CarController::class, 'carpredictPrice'])->name('car.predictPrice');



Route::get('/car-details/{id}', [CarController::class, 'showDetails'])->name('car.details');
});
route::get('/', [CarController::class, 'ShowindexPage'])->name('font.car');






