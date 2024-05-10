@extends('user.includes.header')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">            
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                            @foreach($categories as $category)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{$category->id}}">
                                        <button onclick="window.location='{{ route('products.by.category', ['categoryId' => $category->id]) }}'" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$category->id}}" aria-expanded="true" aria-controls="collapse{{$category->id}}">
                                            {{$category->name}}
                                        </button>
                                    </h2>
                                    <div id="collapse{{$category->id}}" class="accordion-collapse collapse show" aria-labelledby="heading{{$category->id}}" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <div class="navbar-nav">
                                                @foreach($category->products as $product)
                                                    <a href="" class="nav-item nav-link">{{$product->product_name}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                                               
                                                    
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            
                            @foreach($brands as $brand)
                            <div class="form-check mb-2">
                                <a  href="{{ route('products.by.brand', $brand->id) }}" class="nav-item nav-link">{{$brand->name}}</a>
                            </div> 
                            @endforeach                
                        </div>
                    </div>

                    
                    
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Latest</a>
                                            <a class="dropdown-item" href="#">Price High</a>
                                            <a class="dropdown-item" href="#">Price Low</a>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        @foreach($products as $product)
                        <div class="col-md-4">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                        @php
                                        $productImage = $product->images->where('sort_order', 1)->first();
                                        $imagePath = $productImage ? asset('product-image/' . $productImage->img) : '';
                                        @endphp
                                        @if($productImage)
                                        <a href="" class="product-img"><img class="card-img-top" src="{{$imagePath}}" alt=""></a>
                                        @endif
                                    
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                                    <div class="product-action">
                                        <a class="btn btn-dark" href="#">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
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
                        @endforeach
                        <div class="col-md-12 pt-5">
                        {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var checkboxes = document.querySelectorAll('.form-check-input');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    var brandId = this.value;
                    window.location.href = "{{ route('products.by.brand', ':brandId') }}".replace(':brandId', brandId);
                }
            });
        });
    });
</script>
@endsection
