<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class CrudUserController extends Controller
{
    public function customAddUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:24|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
            'gender' => 'required',
            'phone' => 'required|regex:/^\d{10,15}$/',
            'address' => 'required|min:10|max:250',
            'img' => 'required', 
        ], [
            'name.required' => 'Trường tên là bắt buộc.',
            'email.required' => 'Trường email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Trường mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
            'password.regex' => 'Mật khẩu phải có ít nhất một chữ số và một chữ cái in hoa.',
            'gender.required' => 'Trường giới tính là bắt buộc.',
            'phone.required' => 'Trường số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại phải có từ 11 đến 15 chữ số.',
            'address.required' => 'Trường địa chỉ là bắt buộc.',
            'address.min' => 'Địa chỉ phải có ít nhất :min ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',
            'img.required' => 'Trường ảnh là bắt buộc.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        $user = new User();

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
            return redirect()->route('admin.listuser')->with('error', 'Không thể xóa người dùng có vai trò là Admin');
        }

        $user->delete();

        return redirect()->route('admin.listuser')->with('success', 'Người dùng đã được xóa thành công');
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
            'password' => 'nullable|min:6|max:24|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
            'gender' => 'required',
            'phone' => 'required|regex:/^\d{10,15}$/',
            'address' => 'required|min:10|max:250', 
            'img' => 'nullable', // Kiểm tra ảnh
        ], [
            'name.required' => 'Trường tên là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
            'password.regex' => 'Mật khẩu phải có ít nhất một chữ số và một chữ cái in hoa.',
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
    public function adminChangePassword(){
        return view('admin.change-password');
    }
    public function postAdminChangePassword(Request $request){
        
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:24|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
            'confirm_password' => 'required',
        ], [
            'old_password.required' => 'Mật khẩu không được bỏ trống.',
            'confirm_password.required' => 'Mật khẩu không được bỏ trống.',
            'new_password.required' => 'Mật khẩu không được bỏ trống.',
            'new_password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'new_password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
            'new_password.regex' => 'Mật khẩu phải có ít nhất một chữ số và một chữ cái in hoa.',
        ]);
        if ($request->new_password !== $request->confirm_password) {
            return redirect()->back()->with('error', 'Mật khẩu mới và xác nhận mật khẩu không giống nhau.');
        }
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không chính xác.');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return redirect()->route('admin.dashboard')->withSuccess('Mật khẩu của bạn đã được thay đổi thành công.');
    }

}
