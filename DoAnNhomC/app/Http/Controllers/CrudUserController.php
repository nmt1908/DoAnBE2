<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
            
        ]);

        $data = $request->all();
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
            'email' => 'required|email|unique:users,id,'.$input['id'],
            'password' => 'required|min:6',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required', 
        ]);

        $user = User::find($input['id']);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->gender = $input['gender'];
        $user->phone = $input['phone'];
        $user->address = $input['address'];



        $user->save();

        return redirect()->route('admin.listuser')->withSuccess('Sửa user thành công!');
    }

    public function readUser(Request $request) {
        $user_id = $request->get('id');
        $user = User::find($user_id);

        return view('crud_user.read', ['user' => $user]);
    }


}
