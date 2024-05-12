<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
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
    <div id="container-forgotpassword">
        <div id="title">
            <i class="material-icons lock">lock</i> Forgot Password
        </div>

        <form method="POST" action="{{ route('forgotpassword') }}">
        @csrf
            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">face</i>
                </div>
                <input id="email" name="email" placeholder="Put your email and get your resetpassword mail!" type="text" required class="validate" autocomplete="off">
            </div>

            <div class="clearfix"></div>

            

            

            <input type="submit" value="Send" />
        </form>
    </div>
</body>

</html>