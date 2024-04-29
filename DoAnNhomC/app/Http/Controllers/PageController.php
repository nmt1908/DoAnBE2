<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class PageController extends Controller
{
    public function adminListUser()
    {
        $users = User::paginate(5);
        return view('admin.user', compact('users'));
    }
    public function accountProfile()
    {
        $user = Auth::user();
        return view('user.account', compact('user'));
    }
}
