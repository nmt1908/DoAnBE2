<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class SearchUserController extends Controller
{
    //searchUser
    // Trong controller
    public function searchUser(Request $request)
    {
        $search = $request->input('search');
        
        // Thực hiện truy vấn để tìm kiếm người dùng
        $users = User::where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->paginate(5);
        
        return view('admin.searchuser', compact('users'));
    }

}
