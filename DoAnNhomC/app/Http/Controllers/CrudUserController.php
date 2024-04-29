<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Hash;
class CrudUserController extends Controller
{
    public function customAddUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'img' => 'required', // Thêm validation cho ảnh
        ]);

        $data = $request->all();

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của ảnh
            // Kiểm tra xem có ảnh đã được tải lên trước đó hay không
            if (!empty($user->img)) {
                // Nếu có, sử dụng lại ảnh đã được tải lên trước đó
                $data['img'] = $user->img;
            } else {
                // Nếu không có, xử lý tệp tin ảnh mới
                $image->move(public_path('user-image/images'), $imageName);
                $data['img'] = $imageName;
            }
        }

        $check = $this->create($data);

        return redirect()->route('admin.listuser')->withSuccess('Tạo user thành công!');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'img' => isset($data['img']) ? $data['img'] : null, // Lưu tên ảnh vào cột img
        ]);
    }
    public function addUser()
    {
        return view('admin.adduser');
    }
    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 1) {
            return redirect()->back()->with('error', 'Không thể xóa người dùng có vai trò là Admin');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Người dùng đã được xóa thành công');
    }
    public function updateUser(Request $request)
    {
        $user_id = $request->get('id');
        $user = User::find($user_id);

        return view('admin.updateuser', ['user' => $user]);
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
            'password' => 'nullable|min:6', // Cho phép mật khẩu có thể trống
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required', 
            'img' => 'nullable', // Kiểm tra ảnh
        ]);

        $user = User::find($input['id']);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->gender = $input['gender'];
        $user->phone = $input['phone'];
        $user->address = $input['address'];
    
        // Nếu có mật khẩu mới được cung cấp, thì cập nhật mật khẩu mới
        if (!empty($input['password'])) {
            $user->password = Hash::make($input['password']);
        }
    
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
    
        return redirect()->route('admin.listuser')->withSuccess('Sửa user thành công!');

    }

    public function readUser(Request $request) {
        $user_id = $request->get('id');
        $user = User::find($user_id);

        return view('crud_user.read', ['user' => $user]);
    }


}
