<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function home(Request $request)
    {
        /*if (!$request->session()->has('cart',  'default')) {
            var_dump('no session'); die;
        }*/
        // $products = 
        $oldcart = $request->session()->get('cart');
        $cart = new Shopping($oldcart);
        // $request->session()->pull('cart');
        return view('home', ['products' => $cart]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function addcart(Request $request, $id)
    {
        // return $request->all();
        $product = Product::find($id);
        $oldcart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Shopping($oldcart);
        $cart->add($product, $product->id);
        $request->session()->put('cart', $cart);
        // $session = $request->session()->put('cart', $cart);
        $getSession = $request->session()->get('cart');
        // $data = $request->session()->all();
        // return $cart;
        dd($getSession);
        // dd($request->session()->get('cart')->totalQty);
        // dd($request->session()->pull('cart'));
        // var_dump($request->session()->has('cart') ? $request->session()->get('cart')->totalQty : 'none'); die;
    }
}
