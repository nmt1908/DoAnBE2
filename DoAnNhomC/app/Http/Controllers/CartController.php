<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
class CartController extends Controller
{
    public function addToCart(Request $request){
        $product = Product::with('images')->find($request->id);
        if ($product == null){
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ]);
        }
        if(Cart::count()>0){
            $cartContent= Cart::content();
            $productAlreadyExist = false;
            foreach($cartContent as $item){
                if($item->id == $product->id){
                    $productAlreadyExist = true;
                }
            }
            if($productAlreadyExist == false){

                Cart::add($product->id,$product->product_name,1,$product->price,['productImage'=>(!empty($product->images)) ? $product->images->first() : '']);
                $status = true;
                $message=$product->product_name.' add in cart';
            }else{
                $status = false;
                $message=$product->product_name.'already add in cart';
            }
        }else{
            Cart::add($product->id,$product->product_name,1,$product->price,['productImage'=>(!empty($product->images)) ? $product->images->first() : '']);
            $status = true;
            $message=$product->product_name.' add in cart';

        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
    public function cart(){
        $cartContent=Cart::content();
        // dd($cartContent);
        $data['cartContent']=$cartContent;
        return view('user.cart',$data);
    }
}
