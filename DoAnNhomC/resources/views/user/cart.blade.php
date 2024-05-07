@extends('user.includes.header')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($listCartItem != null)
                                @foreach($listCartItem as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                        
                                            
                                            <img src="" width="" height="">
                                            
                                            <h2>{{$item->product->product_name}}</h2>
                                        </div>
                                    </td>
                                    <td class="price">${{$item->product->price}}</td>
                                    <td>
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input id="qty{{$item->id}}" type="text" class="form-control form-control-sm  border-0 text-center" value="{{$item->quantity}}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="total">

                                        ${{ number_format($item->product->price * $item->quantity)}}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                <script>
                                    // Sử dụng jQuery để bắt sự kiện khi input mất focus
                                    $('#qty{{$item->id}}').on('blur', function() {
                                        // Lấy giá trị mới từ input
                                        var newValue = $(this).val();

                                        // Log giá trị mới ra console
                                        console.log(newValue);
                                    });
                                </script>

                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>$400</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                <div>$20</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div class="cart-total">$420</div>
                            </div>
                            <div class="pt-5">
                                <a href="login.php" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                    <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control">
                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

</main>
@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



@endsection