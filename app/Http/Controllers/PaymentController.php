<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Exception\SignatureVerificationException;

class PaymentController extends Controller
{
    //

    public function processPayment(Request $request,$productId)
    {
        $product = Product::findOrFail($productId);

        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $product->price * 100,
            'currency' => 'inr',
            'payment_method_types' => ['card'],
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'status' => 'pending',
            'amount' => $product->price,
            'order_date' => now()
        ]);

        Payment::create([
            'stripe_payment_id' => $paymentIntent->id,
            'order_id' => $order->id,
            'user_id' => $user->id,
            'status' => 'pending',
            'amount' => $product->price,
            'payment_date' => now()
        ]);

        return view('purchase.index', [
            'product' => $product,
            'clientSecret' => $paymentIntent->client_secret,
            'orderId' => $order->id
        ]);

    }


    public function getPaymentStatus($paymentId)
    {
        $payment = Payment::where('stripe_payment_id', $paymentId)->first();

        if (!$payment) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json(['status' => $payment->status]);
    }



    public function handleWebhook(Request $request)
    {
        // Log::error("handleWebhook");


        $payload = $request->getContent();
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null;
        $webhook_secret = config('services.stripe.webhook_secret');

        if (!$sig_header) {
            return response()->json(['error' => 'Signature not found'], 400);
        }

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $webhook_secret);
        } catch (SignatureVerificationException $e) {
            // Log::error("webhook error: " . $e->getMessage());
            return response()->json(['error' => 'Invalid Signature'], 400);
        }
        $paymentIntent = $event->data->object;
        $status = $paymentIntent->status;

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->updatePaymentStatus($paymentIntent->id, 'succeeded');
                break;

            case 'payment_intent.payment_failed':
                $this->updatePaymentStatus($paymentIntent->id, 'failed');
                break;

            case 'payment_intent.canceled':
                $this->updatePaymentStatus($paymentIntent->id, 'canceled');
                break;

            default:
        }

        return response()->json(['message' => 'Webhook received']);
    }


    private function updatePaymentStatus($stripePaymentId, $status)
    {
        $payment = Payment::where('stripe_payment_id', $stripePaymentId)->first();
        if ($payment) {
            $payment->update(['status' => $status]);

            $order = Order::where('id', $payment->order_id)->first();
            if ($order) {
                $order->update(['status' => $status === 'succeeded' ? 'completed' : 'failed']);
            }
        } else {
            // Log::error("updatePaymentStatus error id: " . $stripePaymentId);
        }
    }


    public function success()
    {
        return view('success');
    }

    public function failed()
    {
        return view('error');
    }

}
