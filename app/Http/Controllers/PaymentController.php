<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Transaction; // Ensure you have a Transaction model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Show the payment page for a specific car.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showPayment($id)
    {
        $car = Car::findOrFail($id);

        // Optional: Check if the car is already sold
        if ($car->is_sold) {
            return redirect()->back()->with('error', 'This car is already sold.');
        }

        return view('payment.payment', compact('car'));
    }

    /**
     * Initiate the payment process with Khalti.
     *
     * @param Request $request
     * @param int $carId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function initiatePayment(Request $request, $carId)
    {
        $car = Car::findOrFail($carId);

        // Optional: Check if the car is already sold
        if ($car->is_sold) {
            return redirect()->back()->with('error', 'This car is already sold.');
        }

        $amount = $car->price * 100; // Convert NPR to Paisa

        // Construct Khalti payment URL
        $khaltiUrl = "https://khalti.com/payment?publicKey=" . config('khalti.public_key')
                    . "&productIdentity=" . $car->id
                    . "&productName=" . urlencode($car->brand . ' ' . $car->model)
                    . "&amount=" . $amount;

        return redirect($khaltiUrl);
    }

    /**
     * Verify the payment after Khalti redirects back.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'amount' => 'required|integer|min:1',
        ]);

        $token = $request->input('token');
        $amount = $request->input('amount');

        // Log the incoming verification request
        Log::info('Khalti Payment Verification Initiated', ['token' => $token, 'amount' => $amount]);

        // Call Khalti API to verify
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . config('khalti.secret_key')
        ])->post('https://khalti.com/api/payment/verify/', [
            'token' => $token,
            'amount' => $amount,
        ]);

        $body = $response->json();

        // Log the response from Khalti
        Log::info('Khalti Payment Verification Response', ['response' => $body]);

        if ($response->successful() && isset($body['idx'])) {
            // Payment is successful
            $carId = $body['product_identity'];
            $car = Car::find($carId);

            if ($car && !$car->is_sold) {
                // Update car status to sold
                $car->is_sold = true;
                $car->buyer_id = Auth::id(); // Assuming you have a buyer_id field
                $car->save();

                // Create a transaction record
                Transaction::create([
                    'user_id' => Auth::id(),
                    'car_id' => $car->id,
                    'transaction_id' => $body['idx'],
                    'amount' => $amount,
                    'status' => 'Completed',
                ]);

                // Redirect to success page or return JSON
                // Option 1: Redirect
                // return redirect()->route('payment.success')->with('message', 'Payment Successful!');

                // Option 2: Return JSON (useful for AJAX requests)
                return response()->json(['success' => true, 'message' => 'Payment successful!']);
            }
        }

        // Payment failed
        // Option 1: Redirect
        // return redirect()->route('payment.failed')->with('error', 'Payment Failed.');

        // Option 2: Return JSON
        return response()->json(['success' => false, 'message' => 'Payment verification failed!']);
    }

    /**
     * Show the payment success page.
     *
     * @return \Illuminate\View\View
     */
    public function paymentSuccess()
    {
        return view('payment.success');
    }

    /**
     * Show the payment failed page.
     *
     * @return \Illuminate\View\View
     */
    public function paymentFailed()
    {
        return view('payment.failed');
    }
}
