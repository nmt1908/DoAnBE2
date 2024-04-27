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
            background-color: #303641;
        }
    </style>
</head>

<body>
    <div id="container-login">
        <div id="title">
            <i class="material-icons lock">lock</i> Login
        </div>

        <form method="POST" action="{{ route('login.custom') }}">
        @csrf
            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">face</i>
                </div>
                <input id="email" name="email" placeholder="Username" type="text" required class="validate" autocomplete="off">
            </div>

            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">vpn_key</i>
                </div>
                <input id="password" name="password" placeholder="Password" type="password" required class="validate" autocomplete="off">
            </div>

            <div class="remember-me">
                <input type="checkbox">
                <span style="color: #DDD">Remember Me</span>
            </div>

            <input type="submit" value="Log In" />
        </form>

        <div class="register">
            Don't have an account yet?
            <a href="{{route('register-user')}}"><button id="register-link">Register here</button></a>
        </div>
    </div>
</body>

</html>