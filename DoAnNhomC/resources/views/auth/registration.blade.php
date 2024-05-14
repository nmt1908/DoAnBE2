<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="description" content="Login - Register Template">
    <meta name="author" content="Lorenzo Angelino aka MrLolok">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            background-image: url('https://static.vecteezy.com/system/resources/previews/008/311/935/non_2x/the-illustration-graphic-consists-of-abstract-background-with-a-blue-gradient-dynamic-shapes-composition-eps10-perfect-for-presentation-background-website-landing-page-wallpaper-vector.jpg');
            background-size: cover; 
            background-position: center;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
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
    <div id="container-register">
        <div id="title">
            <i class="material-icons lock">lock</i> Register
        </div>

        <form action="{{ route('register.custom') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">face</i>
                </div>
                <input type="text" placeholder="Name" id="name" name="name" required class="validate" autocomplete="off">
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">email</i>
                </div>
                <input type="text" placeholder="Email" id="email_address" name="email" required class="validate" autocomplete="off">
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">vpn_key</i>
                </div>
                <input type="password" placeholder="Password" id="password" name="password" required class="validate" autocomplete="off">
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">phone</i>
                </div>
                <input type="text" placeholder="Phone" id="phone" name="phone" required class="validate" autocomplete="off">
                @if ($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
            </div>

            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">image</i>
                </div>
                <input type="file" id="img" name="img" required class="validate" accept="image/*" onchange="previewImage(event)">
                @if ($errors->has('img'))
                    <span class="text-danger">{{ $errors->first('img') }}</span>
                @endif
            </div>

            <div id="imagePreview" style="max-width:100%; max-height:200px; padding-top:20px;"></div>

            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">location_on</i>
                </div>
                <input type="text" placeholder="Address" id="address" name="address" required class="validate" autocomplete="off">
                @if ($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
            </div>

            <div class="remember-me">
                <input type="checkbox" id="terms_checkbox">
                <span style="color: #DDD">I accept Terms of Service</span>
            </div>

            <input type="submit" value="Register" id="register_button" />
        </form>


        <div class="register">
            Do you already have an account?
            <a href="{{route('login')}}"><button id="register-link">Log In here</button></a>
        </div>
    </div>

    <script>
        function validateForm() {
            var checkbox = document.getElementById("terms_checkbox");
            if (!checkbox.checked) {
                alert("Please accept the Terms of Service.");
                return false;
            }
            return true;
        }
    </script>
    <script>
        function previewImage(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var imagePreview = document.getElementById('imagePreview');
                    imagePreview.innerHTML = '<img src="' + event.target.result + '" style="max-width:100%; max-height:200px;" />';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>
