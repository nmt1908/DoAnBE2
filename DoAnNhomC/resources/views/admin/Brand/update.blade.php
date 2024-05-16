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
                <h1>Update Brand</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.listBrand') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">

        <form action="{{ route('admin.postUpdateBrand') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Thêm token CSRF -->
            <input name="id" type="hidden" value="{{$brand->id}}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$brand->name}}" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" value="{{$brand->slug}}" placeholder="Slug">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control"  accept="image/*">
                                <div id="imagePreview"></div>
                                @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" @if($brand->status == '1') selected @endif>Action</option>
                                    <option value="0" @if($brand->status == '0') selected @endif>Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.listBrand') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
<script>
document.getElementById('image').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(event) {
            var imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = '<img  src="' + event.target.result +
                '" style="max-width:100%; max-height:200px;padding-top:20px" />';
        };
        reader.readAsDataURL(file);
    }
});

// Hiển thị ảnh người dùng hiện tại trong imagePreview khi trang tải
window.addEventListener('DOMContentLoaded', function() {
        var currentImage = document.getElementById('currentImage');
        if (currentImage) {
            var imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = '<img src="' + currentImage.src + '" style="max-width:100%; max-height:150px;padding-top:20px" />';
        }
    });
</script>
@if($brand->image)
    <img src="{{ asset('brand-image/images/' . $brand->image) }}" id="currentImage" style="display: none;">
    <div id="imagePreview"></div>
@else
    <p>No image available</p>
@endif
@endsection