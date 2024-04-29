@extends('admin.navbar')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Update User</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.listuser') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Bắt đầu form -->
                <form action="{{ route('admin.postUpdateUser') }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- Thêm token CSRF -->
                    <input name="id" type="hidden" value="{{$user->id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" placeholder="Name">
                                @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}" placeholder="Email" readonly>
                                @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
                                @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone">New Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{$user->phone}}" placeholder="New Phone">
                                @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender">New Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="Nam" @if($user->gender == 'Nam') selected @endif>Nam</option>
                                    <option value="Nữ" @if($user->gender == 'Nữ') selected @endif>Nữ</option>
                                    <option value="Không rõ" @if($user->gender == 'Không rõ') selected @endif>Không rõ</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address">New Address</label>
                                <textarea name="address" id="address" class="form-control" cols="30" rows="5">{{$user->address}}</textarea>
                                @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="img">Image</label>
                                <input type="file" name="img" id="img" class="form-control" accept="image/*">
                                <div id="imagePreview"></div>
                                @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Kết thúc form -->
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.listuser') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
<script>
    document.getElementById('email').addEventListener('click', function() {
        alert('Không được phép sửa email!');
    });
</script>
<script>
    document.getElementById('img').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.innerHTML = '<img src="' + event.target.result + '" style="max-width:100%; max-height:200px;padding-top:20px" />';
            };
            reader.readAsDataURL(file);
        }
    });

    // Hiển thị ảnh người dùng hiện tại trong imagePreview khi trang tải
    window.addEventListener('DOMContentLoaded', function() {
        var currentImage = document.getElementById('currentImage');
        if (currentImage) {
            var imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = '<img src="' + currentImage.src + '" style="max-width:100%; max-height:200px;padding-top:20px" />';
        }
    });
</script>
@if($user->img)
    <img src="{{ asset('user-image/images/' . $user->img) }}" id="currentImage" style="display: none;">
    <div id="imagePreview"></div>
@else
    <p>No image available</p>
@endif
@endsection
