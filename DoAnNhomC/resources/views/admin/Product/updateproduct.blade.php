@extends('admin.navbar')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<!-- Content Header (Page header) -->
<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Update Product</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{route('admin.listProduct')}}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
                    <form method="POST" action="{{ route('admin.postUpdateProduct') }}" enctype="multipart/form-data">
                        @csrf
                        <input name="id" type="hidden" value="{{$product->id}}">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mb-3">
                                        <div class="card-body">								
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="product_name">Product name</label>
                                                        <input type="text" name="product_name" id="product_name" value="{{$product->product_name}}" class="form-control" placeholder="Name">	
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="description">Description</label>
                                                        <textarea name="description" id="description" cols="30" rows="10"  class="summernote" placeholder="Description">{{$product->description}}</textarea>
                                                    </div>
                                                </div>                                            
                                            </div>
                                        </div>	                                                                      
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Pricing</h2>								
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="price">Price</label>
                                                        <input type="text" name="price" id="price" value="{{$product->price}}" class="form-control" placeholder="Price">	
                                                    </div>
                                                </div>
                                            </div>
                                        </div>	                                                                      
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">	
                                            <h2 class="h4 mb-3">Product status</h2>
                                            <div class="mb-3">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1" {{$product->status == 1 ? 'selected' : ''}}>Active</option>
                                                    <option value="0" {{$product->status == 0 ? 'selected' : ''}}>Block</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="card">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Product category</h2>
                                        <div class="mb-3">
                                            <label for="category">Category</label>
                                            <select name="category_id" id="category" class="form-control">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> 
                                            <!-- <div class="mb-3">
                                                <label for="category">Sub category</label>
                                                <select name="sub_category" id="sub_category" class="form-control">
                                                    <option value="">Mobile</option>
                                                    <option value="">Home Theater</option>
                                                    <option value="">Headphones</option>
                                                </select>
                                            </div> -->
                                        </div>
                                    </div> 
                                    <div class="card mb-3">
                                        <div class="card-body">	
                                            <h2 class="h4 mb-3">Product brand</h2>
                                            <div class="mb-3">
                                                <select name="brand_id" id="brand" class="form-control">
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                            {{ $brand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Quantity</h2>								
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <input type="number" min="0" name="quantity" value="{{ $product->quantity }}" id="quantity" class="form-control" placeholder="Quantity">	
                                                </div>
                                            </div>                                         
                                        </div>
                                    </div>	                                                                      
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Featured product</h2>
                                        <div class="mb-3">
                                            <select name="is_featured" id="is_featured" class="form-control">
                                                <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                 
                                </div>
                            </div>
                            
                            <div class="pb-5 pt-3">
                                <button class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.listProduct') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </div>
					<!-- /.card -->
                    </form>
				</section>

                @endsection
