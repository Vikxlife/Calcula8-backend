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

use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends BaseController
{

//     /**
//      * Redirect the User to Paystack Payment Page
//      * @return \Url
//      */
//     public function redirectToGateway(Request $request)
//     {
//         try{
//             $redirectUrl = Paystack::getAuthorizationUrl()->redirectNow();
//             return response()->json(['redirectUrl' => $redirectUrl->getTargetUrl()], 200);

//         }catch(\Exception $e) {
//             return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
//         }        
//     }

//     /**
//      * Obtain Paystack payment information
//      * @return void
//      */
//     public function handleGatewayCallback()
//     {
//         $id = Auth::id();

//         $student = User::where('user_id',$id)->first();
//         // $student_id = $student->id; 
        
//         // $paymentDetails = Paystack::getPaymentData(); //this comes with all the data needed to process the transaction
//     }





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


    public function handleGatewayCallback()
    {
        try {
            $paymentDetails = Paystack::getPaymentData();

            response()->json([$paymentDetails]);

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