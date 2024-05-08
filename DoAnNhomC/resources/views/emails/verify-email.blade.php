<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận Email</title>
</head>
<body>
    <h2>Xác nhận Email</h2>
    <p>Vui lòng xác nhận email của bạn bằng cách nhấp vào đường dẫn sau:</p>
    <a href="{{ route('verify.email', ['token' => $token]) }}">Xác nhận Email</a>
</body>
</html>
