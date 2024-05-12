<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Output\Output;

class CartController
{
    public function addCart(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart === null) {
            $cart =  Cart::create(
                [
                    'user_id' => $user->id,
                ]
            );
        }
        $cartItem = CartItem::where('product_id', $request->product_id)->where('cart_id', $cart->id)->first();
        if ($cartItem === null) {
            $cartItems = CartItem::create([
                'quantity' => $request->quantity,
                'cart_id' => $cart->id,
                'product_id' => $request->product_id
            ]);
        } else {
            $cartItems = CartItem::where('product_id', $request->product_id)
                ->where('cart_id', $cart->id)
                ->update([
                    'quantity' => $request->quantity,
                ]);
        }
        return response()->json(['success' => true]);
    }
    public function cart()
    {
        $total = 0;
        $user = Auth::user();
        $listCartItem = null;
        $listProduct = [];
        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart != null) {

            $listCartItem = CartItem::with('product')->where('cart_id', $cart->id)->get();
            // dd($listCartItem);



            $countProducts = $listCartItem->count();

            foreach ($listCartItem as $item) {
                $subtotal = $item->product->price * $item->quantity;
                $total += $subtotal;
            }
            session()->put('countProducts', $countProducts);
        }

        $totalPrice = CartItem::with('product')->get()->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $totalAllProduct = $totalPrice + 20;

        session()->put('total', $total);
        return view('user.cart', ['listCartItem' => $listCartItem, 'total' => $total, 'totalPrice' => $totalPrice, 'totalAll' => $totalAllProduct]);
    }
    public function updateCart(Request $request)
    {
        $cartProduct =  CartItem::where('id', $request->product_id)->pluck('product_id')->first();
        $price = Product::where('id', $cartProduct)->pluck('price')->first();

        CartItem::find($request->product_id)->update([
            'quantity' => $request->total
        ]);
        $total = '';
        $totalAll = '';
        $subTotal = '';

        $total .= '$' . $request->total * $price;

        $totalPrice  = CartItem::with('product')->get()->sum(function ($item) {

            return $item->product->price * $item->quantity;
        });
        $subTotal .= '$' . $totalPrice;

        $totalAll .= '$' . $totalPrice + 20;
        return response()->json([
            'total' => $total,
            'totalPrice' => $subTotal,
            'totalAll' => $totalAll
        ]);
    }
    //goToWishList

 
    public function deleteCart($id)
    {
        $user = Auth::user();
        $listCartItem = null;
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart != null) {
            $listCartItem = CartItem::destroy($id);
        }
        return redirect('/cart');
    }
    public function editCart($id, Request $request)
    {

        $user = Auth::user();
        $listCartItem = null;
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart != null) {
            $cartItems = CartItem::find($id)
                ->update([
                    'quantity' => $request->quantity,
                ]);
        }
        return redirect('/cart/show');
    }
}
