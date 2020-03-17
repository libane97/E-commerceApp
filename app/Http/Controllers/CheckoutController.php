<?php

namespace App\Http\Controllers;

use App\OrderModel;
use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cart::count() <= 0) {
            return redirect()->route('index');
        }
        Stripe::setApiKey('sk_test_GoiJMtUH48DooB97vN7k58Ty00OXQBRgRV');

        $intent = PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'eur'
        ]);

        $clientsecret = Arr::get($intent, 'client_secret');
        return view('checkout.index',[
            'clientsecret' => $clientsecret
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();
        $Order = new OrderModel();
        $Order->payment_intent_id = $data['paymentIntent']['id'];
        $Order->amount = $data['paymentIntent']['amount'];
        $Order->payment_created_at = (new DateTime())
        ->setTimestamp($data['paymentIntent']['created'])
        ->format('Y-m-d H:i:s');
       // return $data['paymentIntent'];

        $products = [];
        $i = 0;
        foreach (Cart::content() as $product) {
            $products['product_' . $i][] = $product->model->title;
            $products['product_' . $i][] = $product->model->price;
            $products['product_' . $i][] = $product->qty;
            $i++;
        }
        $Order->products = serialize($products);
        $Order->user_id = 15;
        $Order->save();

        if ($data['paymentIntent']['status'] === 'succeeded') {
            Cart::destroy();
            Session::flash('success', 'Votre commande a été traitée avec succès.');
            return response()->json(['success' => 'Payment Intent Succeeded']);
        } else {
            return response()->json(['error' => 'Payment Intent Not Succeeded']);
        }
    }
    public function thankyou()
    {
        return Session::has('success') ? view('checkout.thankYou') : redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
