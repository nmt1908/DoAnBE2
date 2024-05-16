<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="description" content="Login - Register Template">
    <meta name="author" content="Lorenzo Angelino aka MrLolok">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
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
    <div id="container-resetpassword">
        <div id="title">
            <i class="material-icons lock">lock</i> Reset Password
        </div>

        <form method="POST" action="{{ route('reset-password.post') }}">
        @csrf
        
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">vpn_key</i>
                </div>
                <input id="newpassword" name="newpassword" placeholder="New password" type="password" required class="validate" autocomplete="off">
                @if ($errors->has('newpassword'))
                                        <span class="text-danger">{{ $errors->first('newpassword') }}</span>
                                    @endif
            </div>

            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">vpn_key</i>
                </div>
                <input id="confirmpassword" name="confirmpassword" placeholder="Confirmpassword" type="password" required class="validate" autocomplete="off">
                @if ($errors->has('confirmpassword'))
                                        <span class="text-danger">{{ $errors->first('confirmpassword') }}</span>
                                    @endif
            </div>
            <div class="clearfix"></div>
            <input type="submit" value="OK" />
        </form>
        
    </div>
</body>

</html>