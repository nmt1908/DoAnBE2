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
                    <ul id="account-panel" class="nav nav-pills flex-column" >
                        <li class="nav-item">
                            <a href="{{route('accountProfile')}}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-login" aria-expanded="false"><i class="fas fa-user-alt"></i> My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="/orders"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-shopping-bag"></i>My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('wishlist')}}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-heart"></i> Wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('change-passwordPage')}}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-lock"></i> Change Password</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('signout')}}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('change-password') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3">               
                                        <label for="old_password">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                    </div>
                                    <div class="mb-3">               
                                        <label for="new_password">New Password</label>
                                        <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                    </div>
                                    <div class="mb-3">               
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control">
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-dark">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection