<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
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
            $products = Product::all();
            return view('user/dashboard', compact('products'));
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
    public function showChangePasswordForm(Request $request)
    {
        // Xử lý thay đổi mật khẩu ở đây

        // Sau khi thay đổi mật khẩu thành công, chuyển hướng người dùng đến một trang khác
        return view('user.change-password');
    }
    public function changePassword(Request $request)
    {
            // Validate the form data
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        if ($request->new_password !== $request->confirm_password) {
            // Return the change-password view with error message
            return redirect()->back()->with('error', 'Mật khẩu mới và xác nhận mật khẩu không giống nhau.');
        }
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the current password matches the password in the database
        if (!Hash::check($request->old_password, $user->password)) {
            // Return the change-password view with error message
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không chính xác.');
        }
        
        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect the user with a success message
        return redirect()->route('accountProfile')->withSuccess('Mật khẩu của bạn đã được thay đổi thành công.');

    }
}