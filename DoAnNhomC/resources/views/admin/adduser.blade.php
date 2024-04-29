@extends('admin.navbar')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create User</h1>
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
                <form action="{{ route('admin.customAddUser') }}" method="POST">
                    @csrf <!-- Thêm token CSRF -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                            </div>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
                                @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender">New Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="Nam" >Nam</option>
                                    <option value="Nữ" >Nữ</option>
                                    <option value="Không rõ">Không rõ</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                  
                    </div>
                    <!-- Kết thúc form -->
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('admin.listuser') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
