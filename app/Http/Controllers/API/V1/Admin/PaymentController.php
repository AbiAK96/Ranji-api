<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Models\V1\Payment;
use App\Models\V1\Job;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class PaymentController extends AppBaseController
{
    public function makePayment(Request $request, $job_id)
    {
        $job = Job::where('id',$job_id)->where('customer_id',auth()->user()->id)->first();
 
        if (empty($job)) {
            return $this->sendResponse(null, null, 'Job not found.');
        }
        
        $payment = Payment::createDetatils($job,$request);
        return $this->sendResponse($payment, 'Payment creation successfully',null);
    }
}
