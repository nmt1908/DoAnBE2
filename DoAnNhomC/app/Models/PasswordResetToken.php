<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;
    protected $table = 'password_reset_tokens'; // Tên của bảng trong cơ sở dữ liệu

    protected $fillable = [
        'email', // Các trường cần được điền vào khi tạo mới một token
        'token',
        'created_at'
    ];
}
