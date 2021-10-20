<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Shakurov\Coinbase\Coinbase;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all()->toArray();
        return array_reverse($payments);
    }

    public function add(Request $request)
    {
        $checkout = new Coinbase();
        $checkout->createCheckout([
            'name' => User::find($request->user_id)->name,
            'description' => $request->description,
            'local_price' => [
                'amount' => $request->amount,
                'currency' => 'USD',
            ],
            'pricing_type' => 'fixed_price',
        ]);
        $payment = new Payment([
            'description' => $request->description,
            'amount' => $request->amount,
            'user_id' => $request->user_id
        ]);

        $payment->save();

        return response()->json('Successfully added');
    }

    public function edit($id)
    {
        $payment = Payment::find($id);
        return response()->json($payment);
    }

    public function delete($id)
    {
        $payment = Payment::find($id);
        $payment->delete();

        return response()->json('Successfully deleted');
    }
}
