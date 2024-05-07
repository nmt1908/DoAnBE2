<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController
{
    public function addCart(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id )->first();
        if ($cart === null){
            $cart =  Cart::create([
                    'user_id'=> $user->id,
                ]
            );
        }
        $cartItem = CartItem::where('product_id', $request->product_id)->where('cart_id',$cart->id)->first();
        if ($cartItem === null){
            $cartItems = CartItem::create([
                'quantity'=> $request->quantity,
                'cart_id'=> $cart->id,
                'product_id'=> $request->product_id
            ]);
        }else{
            $cartItems = CartItem::where('product_id', $request->product_id)
                ->where('cart_id',$cart->id)
                ->update([
                'quantity'=> $request->quantity,
            ]);
        }
        return response()->json(['success' => true]);
    }
    public function cart()
    {
        $total = 0;
        $user = Auth::user();
        $listCartItem = null;
        $listProduct= [] ;
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
        
        session()->put('total', $total);
        return view('user.cart', ['listCartItem' => $listCartItem, 'total' => $total]);
       

    }
    public function deleteCart($id){
        $user = Auth::user();
        $listCartItem = null;
        $cart = Cart::where('user_id', $user->id )->first();
        if ($cart != null){
            $listCartItem = CartItem::destroy($id);
        }
        return redirect('/cart/show');
    }
    public function editCart($id,Request $request){

        $user = Auth::user();
        $listCartItem = null;
        $cart = Cart::where('user_id', $user->id )->first();
        if ($cart != null){
            $cartItems = CartItem::find($id)
                ->update([
                    'quantity'=> $request->quantity,
                ]);
        }
        return redirect('/cart/show');
    }
}