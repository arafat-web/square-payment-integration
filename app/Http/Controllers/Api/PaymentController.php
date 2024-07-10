<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Square\Models\CreatePaymentRequest; 
use Square\Models\Money;
use Square\SquareClient;

class PaymentController extends Controller
{
    protected $squareClient;

    public function __construct(SquareClient $squareClient)
    {
        $this->squareClient = $squareClient;
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'nonce' => 'required|string',
        ]);

        $order = Order::findOrFail($request->input('order_id'));

        if ($order = $order->transactions()->first()) {
            return response()->json(['message' => 'Payment already processed'], 200);
        }
        $amount = $request->input('amount');
        $currency = 'USD';

        $amountMoney = new Money();
        $amountMoney->setAmount($amount);
        $amountMoney->setCurrency($currency);

        $locationId = config('app.square.location_id');
        $nonce = $request->input('nonce');
        $idempotencyKey = uniqid();

        $createPaymentRequest = new CreatePaymentRequest($locationId, $idempotencyKey);
        $createPaymentRequest->setSourceId($nonce);
        $createPaymentRequest->setAmountMoney($amountMoney);

        $paymentsApi = $this->squareClient->getPaymentsApi();

        try {
            $response = $paymentsApi->createPayment($createPaymentRequest);

            if ($response->isSuccess()) {
                $order->update(['payments' => 'Paid']);
                $payment = $response->getResult()->getPayment();
                $transaction = new Transaction([
                    'user_id' => auth()->user()->id,
                    'order_id' => $request->input('order_id'),
                    'square_payment_id' => $payment->getId(),
                    'amount' => $amount,
                    'currency' => $currency,
                    'status' => $payment->getStatus(),
                    'card_brand' => $payment->getCardDetails()->getCard()->getCardBrand(),
                    'card_last_four' => $payment->getCardDetails()->getCard()->getLast4(),
                    'card_exp_month' => $payment->getCardDetails()->getCard()->getExpMonth(),
                    'card_exp_year' => $payment->getCardDetails()->getCard()->getExpYear(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'receipt_url' => $payment->getReceiptUrl(),
                ]);
                $transaction->save();
                return response()->json(['message' => 'Payment Successful', 'data' => $payment], 200);
            } else {
                return response()->json(['error' => $response->getErrors()], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}
