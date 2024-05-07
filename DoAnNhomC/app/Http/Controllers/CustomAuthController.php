<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Carbon\Carbon; 
use App\Models\PasswordResetToken;

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
    public function goForgotPassword()
    {
        return view('auth.forgotpassword');
    }
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', compact('token'));
    }
    public function resetPassword(Request $request)
    {
        
        $request->validate([
            'newpassword' => 'required',
            'confirmpassword' => 'required',
        ]);
        if ($request->newpassword !== $request->confirmpassword) {
            return redirect()->back()->with('error', 'Mật khẩu mới và xác nhận mật khẩu không giống nhau.');
        }
        $tokenRecord = PasswordResetToken::where('token', $request->token)->first();
        $user = User::where('email', $tokenRecord->email)->first();
        $user->password = Hash::make($request->newpassword);
        $user->save();
        $tokenRecord->delete();
        return redirect()->route('login')->with('success', 'Mật khẩu đã được thay đổi thành công!.');
        
    }
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->with('success', 'Email không tồn tại!');
        }
    
        // Kiểm tra xem đã tồn tại token cho email này chưa
        $existingToken = DB::table('password_reset_tokens')
                            ->where('email', $user->email)
                            ->first();
    
        if ($existingToken) {
            // Nếu tồn tại, cập nhật lại token hiện tại
            $token = $existingToken->token;
        } else {
            // Nếu không tồn tại, tạo token mới
            $token = Str::random(60);
    
            // Lưu token vào cơ sở dữ liệu
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => now()
            ]);
        }
    
        // Gửi email với token
        Mail::to($user->email)->send(new PasswordResetMail($token));
    
        return back()->with('success', 'Email khôi phục mật khẩu đã được gửi!');
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