<?php

namespace App\Http\Controllers\Paystack;

use App\Http\Controllers\BaseController;
use App\Models\ExamSubscription;
use Illuminate\Http\Request;

// use App\Http\Requests;
use App\Models\Paystack\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends BaseController
{

    /**
     * Show the payment form.
     *
     * @return \Illuminate\View\View
     */

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|integer',
        ]);

       $user = Auth::user();

       if(!$user){
            return response()->json([
                'message' => 'Invalid user, cannot send request',
            ]);
       }

       $paymentRequestData = [
            'email' => $user->email,
            'id'    => $user->_id,
            'amount' => $request->amount,
            'reference' => Paystack::genTranxRef(), 
            'callback_url' => route('paystack.callback'), 
        ];

        try {

            $redirectUrl = Paystack::getAuthorizationUrl($paymentRequestData)->redirectNow();
                   
            return response()->json(['redirectUrl' => $redirectUrl->getTargetUrl(),], 200);
            
        }catch(\Exception $e) {
            return response()->json(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }
    }


    public function handleGatewayCallback(Request $request)
    {
       
        try {
            $paymentDetails = Paystack::getPaymentData();

            return response()->json([
                'data' => $paymentDetails
            ]);

            if ($paymentDetails->data->status == 'success') {
                $email = $paymentDetails->data->customer->email; 

                ExamSubscription::create([
                    'status' => true,
                    'email' => $email
                ]);

                return response()->json(['msg' => 'success']);
            } else {
                return response()->json(['msg' => 'failed']);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Error handling payment callback', 'type' => 'error'], 500);
        }
    }

}