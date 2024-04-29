<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

//Unknow
class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 1) {
                return redirect()->route('admin.dashboard')
                    ->withSuccess('Đăng nhập thành công');
            } else {
                return redirect()->route('dashboard')
                    ->withSuccess('Đăng nhập thành công');
            }
        }
    
        return redirect("login")->withSuccess('Sai tài khoản hoặc mật khẩu!');
    }

    public function registration()
    {
        return view('auth.registration');
    }
    public function adminDashboard()
    {
        return view('admin/dashboard');
        
    }
    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("login")->withSuccess('Đăng kí thành công! Bạn có thể đăng nhập vào tài khoản');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('user/dashboard');
        }

        return redirect("login")->withSuccess('Bạn cần phải đăng nhập!');
    }
    // public function dashboardFirstLogin()
    // {
    //         return view('user/dashboard');
    // }
    public function dashboardFirstLogin()
    {
        return view('auth.login');
    }
    public function signOut() {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}