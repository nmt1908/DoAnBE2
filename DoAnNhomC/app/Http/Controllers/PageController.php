<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;

use Hash;class PageController extends Controller
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

    public function updateUser(Request $request)
    {
        $user = Auth::user();
        return view('user.updateaccount', compact('user'));
    }

    /**
     * Submit form update user
     */
    public function postUpdateUser(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$input['id'],
            'gender' => 'required',
            'phone' => 'required|regex:/^\d{10,15}$/',
            'address' => 'required|min:10|max:250', 
            'img' => 'nullable', // Kiểm tra ảnh
        ], [
            'name.required' => 'Trường tên là bắt buộc.',
            'gender.required' => 'Trường giới tính là bắt buộc.',
            'phone.required' => 'Trường số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại phải có từ 11 đến 15 chữ số.',
            'address.required' => 'Trường địa chỉ là bắt buộc.',
            'address.min' => 'Địa chỉ phải có ít nhất :min ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',
        ]);

        $user = User::find($input['id']);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->gender = $input['gender'];
        $user->phone = $input['phone'];
        $user->address = $input['address'];
    
        // Kiểm tra xem người dùng đã cung cấp một tệp tin ảnh mới hay không
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của ảnh
            $image->move(public_path('user-image/images'), $imageName);
            $user->img = $imageName;
        } elseif (empty($input['img'])) {
            // Nếu không có tệp tin ảnh mới được tải lên và không có giá trị trong trường img, 
            // tức là người dùng không muốn thay đổi ảnh, sử dụng ảnh cũ.
            $user->img = $user->img;
        }
    
        $user->save();
    
        return redirect()->route('accountProfile')->withSuccess('Sửa user thành công!');

    }

    public function page($slug) {
        $page = Page::where('slug',$slug)->first();
        return view('user.page',[
            'page' => $page
    ]);
    }
}