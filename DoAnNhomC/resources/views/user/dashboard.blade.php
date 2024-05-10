@extends('user.includes.header')

@section('content')
<main>
<section class="section-1">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
        <div class="carousel-inner">
            @foreach ($banners as $key => $banner)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset('banner-image/' . $banner->img_banner) }}" alt="" />

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">{{ $banner->name_banner }}</h1>
                            <p class="mx-md-5 px-5">{{ $banner->description_banner }}</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<section class="section-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Sản phẩm chất lượng</h5>
                </div>                    
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Giao hàng miễn phí</h2>
                </div>                    
            </div>
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Đổi trả thoải mái</h2>
                </div>                    
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Hỗ trợ 24/7</h5>
                </div>                    
            </div>
        </div>
    </div>
</section>
<section class="section-3">
    <div class="container">
        <div class="section-title">
            <h2>Categories</h2>
        </div>           
        <div class="row pb-3">
        @foreach ($categories as $category)
    <div class="col-lg-3">
        <div class="cat-card">
            <div class="left">
                <img src="{{ asset('category-image/images/' . $category->image) }}"  alt="" class="img-fluid">
            </div>
            <div class="right">
                <div class="cat-data">
                    <h2>{{$category->name}}</h2>
                    
                    <p>{{ $category->products()->count() }} Products</p>
                    
                </div>
            </div>
        </div>
    </div>
@endforeach
    </div>
</section>
<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Featured Products</h2>
        </div>    
        <div class="row pb-3">
            @foreach($products as $product)
                @if($product->is_featured == 1)
                <div class="col-md-3">
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            @php
                                $productImage = $product->images->where('sort_order', 1)->first();
                                $imagePath = $productImage ? asset('product-image/' . $productImage->img) : '';
                            @endphp
                            @if($productImage)
                                 <a href="" class="product-img"><img class="card-img-top" src="{{ $imagePath }}" alt=""></a>
                            @endif
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                            <div class="product-action">
                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$product->id}});">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart1
                                </a>                            
                            </div>
                        </div>                        
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="product.php">{{$product->product_name}}</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>${{$product->price}}</strong></span>
                                <span class="h6 text-underline"><del>$120</del></span>
                            </div>
                        </div>                        
                    </div>                                              
                </div>  
                @endif
            @endforeach
              
        </div>
    </div>
</section>

<section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Latest Produsts</h2>
            </div>    
            <div class="row pb-3">
                <!-- @foreach($products as $product)
                    @if($product->is_new == 1)
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="" class="product-img"><img class="card-img-top" src="{{ asset('user-acess/images/product-1.jpg') }}" alt=""></a>
                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                                <div class="product-action">
                                    <a class="btn btn-dark" href="#">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>                            
                                </div>
                            </div>                        
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="product.php">Dummy Product Title</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>$100</strong></span>
                                    <span class="h6 text-underline"><del>$120</del></span>
                                </div>
                            </div>                        
                        </div>                                               
                    </div>  
                    @endif
                @endforeach -->
                @foreach($products as $product)
                    @php
                        $sevenDaysAgo = now()->subDays(7); // Tính ngày 7 ngày trước từ ngày hiện tại
                    @endphp
                    @if($product->created_at >= $sevenDaysAgo)
                        <div class="col-md-3">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                @php
                                $productImage = $product->images->where('sort_order', 1)->first();
                                $imagePath = $productImage ? asset('product-image/' . $productImage->img) : '';
                                @endphp
                                @if($productImage)
                                    <a href="" class="product-img"><img class="card-img-top" src="{{ $imagePath }}" alt=""></a>
                                @endif
                                    
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                                    <div class="product-action">
                                        <a class="btn btn-dark" href="#">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>                            
                                    </div>
                                </div>                        
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{ $product->product_name }}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>${{ $product->price }}</strong></span>
                                        <span class="h6 text-underline"><del>$120</del></span>
                                    </div>
                                </div>                        
                            </div>                                               
                        </div>  
                    @endif
                @endforeach
            </div>
        </div>
</section>
</main>

@endsection


