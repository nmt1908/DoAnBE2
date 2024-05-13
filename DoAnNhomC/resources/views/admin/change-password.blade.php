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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successAlert = document.querySelector('.alert-danger');

        if (successAlert) {
            
            setTimeout(function () {
                successAlert.style.display = 'none'; 
            }, 3000); 
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successAlert = document.querySelector('.alert-success');

        if (successAlert) {
            
            setTimeout(function () {
                successAlert.style.display = 'none'; 
            }, 3000); 
        }
    });
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Admin Change Password</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Back</a>
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
                <form action="{{ route('admin.postChangePassword') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-6">
                                <label for="old_password">Old Password</label>
                                <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old password">
                                @if ($errors->has('old_password'))
                                    <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <div class="mb-6">
                                <label for="new_password">New password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New password">
                                @if ($errors->has('new_password'))
                                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <div class="mb-6">
                                <label for="confirm_password">Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password">
                                @if ($errors->has('confirm_password'))
                                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Change</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
<script>
    document.getElementById('img').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.innerHTML = '<img  src="' + event.target.result + '" style="max-width:100%; max-height:200px;padding-top:20px" />';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
