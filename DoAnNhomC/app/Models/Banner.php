<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Banner extends Model
{
    use HasFactory, HasFactory, Notifiable;
    protected $fillable = [
        'img_banner',
        'name_banner',
        'description_banner',
        'status',
    ];
}
