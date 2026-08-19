<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Mail;
use App\Mail\EbookPurchaseMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    private $razorpayId;
    private $razorpaySecret;

    public function __construct()
    {
        $this->razorpayId = env('RAZORPAY_KEY', 'rzp_test_placeholder');
        $this->razorpaySecret = env('RAZORPAY_SECRET', 'secret_placeholder');
    }

    public function index($product)
    {
        if ($product !== 'kids-learning-ebook') {
            abort(404);
        }

        // Set static price for the eBook (e.g. 99 INR for testing)
        $price = 99;
        
        return view('frontend.checkout.index', compact('product', 'price'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'product' => 'required|string'
        ]);

        $amount = 99; // 99 INR

        $api = new Api($this->razorpayId, $this->razorpaySecret);

        $orderData = [
            'receipt'         => 'rcptid_' . time(),
            'amount'          => $amount * 100, // Amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        try {
            $razorpayOrder = $api->order->create($orderData);
        } catch (\Exception $e) {
            Log::error('Razorpay Order Create Error: ' . $e->getMessage());
            return back()->withError('Payment gateway error. Please try again.');
        }

        // Save order in database
        $order = Order::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'product_name' => $validated['product'],
            'amount' => $amount,
            'razorpay_order_id' => $razorpayOrder['id'],
            'status' => 'pending'
        ]);

        return view('frontend.checkout.payment', [
            'order' => $order,
            'razorpayOrderId' => $razorpayOrder['id'],
            'amount' => $amount * 100,
            'razorpayId' => $this->razorpayId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? ''
        ]);
    }

    public function callback(Request $request)
    {
        $signatureStatus = false;
        $api = new Api($this->razorpayId, $this->razorpaySecret);

        try {
            $attributes = array(
                'razorpay_signature' => $request->razorpay_signature,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id
            );
            $api->utility->verifyPaymentSignature($attributes);
            $signatureStatus = true;
        } catch (\Exception $e) {
            Log::error('Razorpay Signature Verification Failed: ' . $e->getMessage());
        }

        if ($signatureStatus) {
            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();
            if ($order && $order->status !== 'completed') {
                $order->status = 'completed';
                $order->razorpay_payment_id = $request->razorpay_payment_id;
                $order->save();

                // Send Email with PDF
                try {
                    Mail::to($order->email)->send(new EbookPurchaseMail($order));
                } catch (\Exception $e) {
                    Log::error('Ebook Mail Send Error: ' . $e->getMessage());
                }
            }

            return redirect()->route('checkout.success')->with('success', 'Payment successful! Your eBook has been emailed to you.');
        } else {
            return redirect()->route('checkout.index', 'kids-learning-ebook')->withError('Payment failed or signature mismatch.');
        }
    }

    public function success()
    {
        if (!session('success')) {
            return redirect('/');
        }
        return view('frontend.checkout.success');
    }
}
