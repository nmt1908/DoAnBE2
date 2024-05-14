@extends('user.includes.header')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form action="{{route('user.addOrders')}}" method="get">


                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No.">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>
                        <div class="card cart-summery">
                            <div class="card-body">
                                @if($listCartItem != null)
                                @foreach($listCartItem as $item)
                                <div class="d-flex justify-content-between pb-2">
                                    <div class="h6">{{$item->product->product_name}} x {{$item->quantity}}</div>
                                    <div class="h6">${{ number_format($item->product->price * $item->quantity)}}</div>
                                </div>
                                <input type="hidden" name="cart[]" value="{{$item->id}}">
                               

                                @endforeach
                                @endif

                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong>${{$totalPrice}}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong>$20</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong>${{$totalAll}}</strong></div>
                                </div>
                                <input type="hidden" name="total" value="${{$totalAll}}">
                            </div>
                        </div>

                        <div class="card payment-form ">

                            <div class="pt-4">
                                <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                            </div>
                        </div>
                    </div>


                    <!-- CREDIT CARD FORM ENDS HERE -->

                </div>
        </div>
        </form>
        </div>
    </section>
</main>
@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



@endsection