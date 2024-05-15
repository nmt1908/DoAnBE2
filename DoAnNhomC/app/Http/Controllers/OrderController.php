<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Output\Output;
use Illuminate\Pagination\Paginator;

class OrderController
{

    public function addOrders(Request $request)
    {

        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->first();
        if ($order === null) {
            $order =  order::create(
                [
                    'user_id' => $user->id,
                ]
            );
        }

        $zip_order = $this->generateUniqueZipOrder();
        $fullName = $request->input('full_name');
        $email = $request->input('email');
        $addres = $request->input('address');
        $mobile = $request->input('mobile');
        $order_notes = $request->input('order_notes');
        $cartIds = $request->input('cart');


        if (!$cartIds) {
            return redirect()->back()->with('error', 'No products selected for checkout.');
        }

        $cartItems = CartItem::whereIn('id', $cartIds)->get();


        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'No valid products found in cart.');
        }
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $orderData[] = [

                    'zip_order' => $zip_order,
                    'fullName' => $fullName,
                    'email' => $email,
                    'address' => $addres,
                    'orderNote' => $order_notes,
                    'phone' => $mobile,
                    'total' => $product->price * $item->quantity,
                    'quantity' => $item->quantity,
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        if (!empty($orderData)) {
            // Insert the order data in bulk
            OrderItem::insert($orderData);

            // Optionally, you can delete the cart items after order is created
            CartItem::whereIn('id', $cartIds)->delete();

            return redirect()->route('user.orders')->with('success', 'Checkout successfully.');
        }

        return redirect()->back()->with('error', 'Failed to process checkout.');
    }

    private function generateUniqueZipOrder()
    {
        do {
            $randomNumber = rand(1000, 9999); // Tạo số ngẫu nhiên từ 1000 đến 9999
            $zipOrder = 'maOrder' . $randomNumber;
        } while (OrderItem::where('zip_order', $zipOrder)->exists());

        return $zipOrder;
    }

    public function orders()
    {
        // Get the current page from the request, default to 1 if not present
        $currentPage = Paginator::resolveCurrentPage();
    
        // Define how many items we want to be visible in each page
        $perPage = 1;
    
        // Get the distinct list of 'zip_order'
        $dsList = OrderItem::distinct()->pluck('zip_order');
    
        // Map and trim the list
        $dsList = $dsList->map(function ($item) {
            return trim($item);
        });
    
        // Get the current page slice of items
        $currentPageItems = $dsList->slice(($currentPage - 1) * $perPage, $perPage);
    
        $totals = [];
    
        foreach ($currentPageItems as $ds) {
            // Get the total quantity of each product with 'zip_order' = $ds
            $total = OrderItem::where('zip_order', $ds)->sum('total');
            $createdAt = OrderItem::where('zip_order', $ds)->first()->created_at;
    
            // Save the total to the array
            $totals[$ds] = ['total' => $total, 'created_at' => $createdAt];
        }
    
        // Create a LengthAwarePaginator instance
        $paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $dsList->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );
    
        return view('user.myOrders', ['dslist' => $paginatedItems, 'totals' => $totals]);
    }
    public function detailOrders($zip_order)
    {
        $order_detail = OrderItem::where('zip_order', $zip_order)->get();

        $dsList = OrderItem::where('zip_order', $zip_order)->firstOrFail();
        $totalPrice = OrderItem::with('product')->get()->sum(function ($item) {

            return $item->product->price * $item->quantity;
        });

        $totalAllProduct = $totalPrice + 20;
        // Chuyển danh sách thành mảng và loại bỏ khoảng trắng


        return view('user.orderDetail', ['order' => $order_detail, 'dslist' => $dsList, 'totalPrice' => $totalPrice, 'totalAll' => $totalAllProduct]);
    }
    public function pays()
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
        return view('user.checkOut', ['listCartItem' => $listCartItem, 'total' => $total, 'totalPrice' => $totalPrice, 'totalAll' => $totalAllProduct]);
    }
}
