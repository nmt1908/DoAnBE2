@extends('user.includes.header')

@section('content')

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    <ul id="account-panel" class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="{{route('accountProfile')}}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-login" aria-expanded="false"><i class="fas fa-user-alt"></i> My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="/orders" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-shopping-bag"></i>My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('wishlist')}}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-heart"></i> Wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('change-passwordPage')}}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-lock"></i> Change Password</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('signout')}}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My WishList</h2>
                        </div>
                        @if($listItem != null)
                        @foreach($listItem as $value)
                        <div class="card-body p-4">
                            <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                @php
                                $productImage = $value->product->images->where('sort_order', 1)->first();
                                $imagePath = $productImage ? asset('product-image/' . $productImage->img) : '';
                                @endphp
                                @if($productImage)
                                <div class="d-block d-sm-flex align-items-start text-center text-sm-start"><a class="d-block flex-shrink-0 mx-auto me-sm-4" href="#" style="width: 10rem;"><img src="{{ $imagePath }}" alt="Product"></a>
                                @endif  
                                <div class="pt-2">
                                        <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">{{$value->product->product_name}}</a></h3>
                                        <div class="fs-lg text-accent pt-2">${{number_format($value->product->price)}}</div>
                                    </div>
                                </div>
                                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                <form action="{{route('wishlist.delete',$value->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" type="submit"><i class="fas fa-trash-alt me-2"></i>Remove</button>
                                            
                                        </form>
                                </div>
                            </div>

                        </div>

                    </div>
                    @endforeach
                    
                    @else($listItem === null)
                    <p>không có sản phẩm nào ở trong giỏ hàng</p>
                    @endif
                    {!! $listItem->links('pagination::bootstrap-5',) !!}
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
@endsection