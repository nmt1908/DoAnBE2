<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function goToWishList()
    {
        $total = 0;
      
        $user = Auth::user();
        $listItem = WishList::with('product')->where('user_id', $user->id)->paginate(1);
       
        return view('user.wishlist', compact('listItem'));
      
        
    }
    public function wishListAdd(Request $request)
    {
        $user = Auth::user();
        // $cart = WishList::where('user_id', $user->id )->first();
        $userItem = WishList::where('product_id', $request->product_id)->where('user_id',$user->id)->first();
        if ($userItem === null){
            $userItem = WishList::create([
                'user_id'=> $user->id,
                'product_id'=> $request->product_id,
                'do_not'=> 0
            ]);
        }
   
        return response()->json(['success' => true]);
    }
    public function wishlistdelete($id){
        $user = Auth::user();
        $listCartItem = null;
        $cart = WishList::where('user_id', $user->id )->first();
        if ($cart != null){
            $listCartItem = WishList::destroy($id);
        }
        return redirect('/user/wishlist');
    }
    
}