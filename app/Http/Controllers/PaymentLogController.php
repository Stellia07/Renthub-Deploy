<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentLog; // Assuming you have a PaymentLog model
use Illuminate\Support\Facades\Auth;

class PaymentLogController extends Controller
{
    public function create()
    {
        $userEmail = auth()->user()->email; // Get the currently logged-in user's email
        $paymentLogs = PaymentLog::all(); // Fetch all payment logs
        $userPaymentLogs = PaymentLog::where('recipient_email', $userEmail)->get(); // Fetch logs specific to the user

        return view('payment-log.create', compact('paymentLogs', 'userPaymentLogs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'receipt_image_path' => 'required|image',
            'recipient_email' => 'required|email',
            'sender_email' => 'required|email',
            'description' => 'required|string',
        ]);

        $paymentLog = new PaymentLog;
        $paymentLog->user_id = auth()->id(); // assuming the user is logged in
        $paymentLog->amount = $request->amount;
        $paymentLog->recipient_email = $request->recipient_email;
        $paymentLog->sender_email = $request->sender_email;
        $paymentLog->description = $request->description;

        if ($request->hasFile('receipt_image_path')) {
            $path = $request->file('receipt_image_path')->store('receipts', 'public');
            $paymentLog->receipt_image_path = $path;
        }

        $paymentLog->save();

        return redirect()->route('payment-log.create')->with('success', 'Payment log created successfully.');
    }

    public function paymentLogs()
    {
        $userEmail = auth()->user()->email;
        $allPaymentLogs = PaymentLog::all();
        $userPaymentLogs = PaymentLog::where('recipient_email', $userEmail)->get();

        return view('owner.payment_logs', compact('allPaymentLogs', 'userPaymentLogs'));
    }
    public function createPay()
    {
        // Logic to display the payment form
        return view('tenant.pay');
    }

    public function viewPaymentLogs()
    {
        // Get the email of the currently logged-in user
        $userEmail = Auth::user()->email;

        // Retrieve all payment logs where the sender_email matches the logged-in user's email
        $myPaymentLogs = PaymentLog::where('sender_email', $userEmail)->get();

        // Pass the retrieved logs to the view
        return view('tenant.view_payment_logs', compact('myPaymentLogs'));
    }
}
