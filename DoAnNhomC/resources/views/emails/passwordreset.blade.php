<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body>
    <p>Click the following link to reset your password:</p>
    <a href="{{ url('/reset-password/'.$token) }}">Reset Password</a>
</body>
</html>