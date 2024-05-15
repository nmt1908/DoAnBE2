@extends('user.includes.header')

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
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="/account">My Account</a></li>
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
                            <a href="{{route('accountProfile')}}" class="nav-link font-weight-bold" role="tab"
                                aria-controls="tab-login" aria-expanded="false"><i class="fas fa-user-alt"></i> My
                                Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="/orders" class="nav-link font-weight-bold" role="tab"
                                aria-controls="tab-register" aria-expanded="false"><i class="fas fa-shopping-bag"></i>My
                                Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('wishlist')}}" class="nav-link font-weight-bold" role="tab"
                                aria-controls="tab-register" aria-expanded="false"><i class="fas fa-heart"></i>
                                Wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('change-passwordPage')}}" class="nav-link font-weight-bold" role="tab"
                                aria-controls="tab-register" aria-expanded="false"><i class="fas fa-lock"></i> Change
                                Password</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('signout')}}" class="nav-link font-weight-bold" role="tab"
                                aria-controls="tab-register" aria-expanded="false"><i class="fas fa-sign-out-alt"></i>
                                Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>
                        <div class="card-body p-4 personal-info"> 
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="mb-3">
                                        <td>
                                            <img src="{{ asset('user-image/images/' . $user->img) }}" alt="Avatar" class="rounded-circle avatar">
                                        </td>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">Name: {{ $user->name }}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email: {{ $user->email }}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">Phone: {{ $user->phone }}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender">Gender: <td>{{ $user->gender }}</td></label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">Address: {{$user->address}}</label>
                                    </div>

                                    <div class="d-flex justify-content-center"> <!-- Thay đổi class d-flex thành justify-content-center để căn giữa theo chiều ngang -->
                                        <a href="{{route('user.updateUser', ['id' => $user->id])}}"><button class="btn btn-dark">Cập nhật Profile</button></a> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="card-body p-4">
                            <div class="row">
                                <div class="mb-3">               
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control" value="{{ $user->name }}">
                                </div>
                                <div class="mb-3">            
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control" value="{{ $user->email }}">
                                </div>
                                <div class="mb-3">                                    
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control" value="{{ $user->phone }}">
                                </div>

                                <div class="mb-3">                                    
                                    <label for="phone">Address</label>
                                    <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Enter Your Address">{{$user->address}}</textarea>
                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-dark">Update</button>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection






