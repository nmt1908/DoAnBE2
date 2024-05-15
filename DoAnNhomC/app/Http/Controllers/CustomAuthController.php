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
use App\Mail\VerifyEmail;
use Carbon\Carbon; 
use App\Models\PasswordResetToken;
use App\Models\Banner;
use App\Models\Categories;
use App\Models\Brand;
use App\Models\WishList;
use App\Models\ProductImage;
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
            'email' => 'required|email|max:100|min:10',
            'password' => 'required|max:24|min:6',
        ], [
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'email.required' => 'Tên đăng nhập không thể bỏ trống.',
            'email.email' => 'Email phải là một địa chỉ email hợp lệ.',
            'email.max' => 'Địa chỉ email không được vượt quá :max ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
            'email.min' => 'Email không được ít hơn :min ký tự.',
            'password.min' => 'Mật khẩu không được ít hơn :min ký tự.',
        ]);
        $credentials = $request->only('email', 'password');
    
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return redirect("login")->withSuccess('Sai tài khoản hoặc mật khẩu!');
        }
    
        if (is_null($user->email_verified_at) || is_null($user->remember_token)) {
            return redirect("login")->withSuccess('Tài khoản chưa được xác minh hoặc không hợp lệ!');
        }
        Auth::login($user);
    
        if ($user->role == 1) {
            return redirect()->route('admin.dashboard')->withSuccess('Đăng nhập thành công');
        } else {
            return redirect()->route('dashboard')->withSuccess('Đăng nhập thành công');
        }
    }

    public function registration()
    {
        return view('auth.registration');
    }
    public function adminDashboard()
    {
        return view('admin/dashboard');
        
    }
    public function showProductOnShop()
    {
        $wishlist = WishList::all();
        $products=Product::paginate(9);
        $brands = Brand::all();
        $categories=Categories::all();
        return view('user.shop',compact('products','brands','categories','wishlist'));
    }
    public function showProductOnShopByBrand($brandId) {
        $brands = Brand::all(); 
        $categories = Categories::all(); 
        $products = Product::whereHas('brand', function ($query) use ($brandId) {
            $query->where('id', $brandId);
        })->paginate(9);
        return view('user.shop', compact('brands','categories','products'));
    }
    public function showProductOnShopByCategory($categoryId) {
        $brands = Brand::all(); 
        $categories = Categories::all(); 
        $products = Product::whereHas('category', function ($query) use ($categoryId) {
            $query->where('id', $categoryId);
        })->paginate(9);
        return view('user.shop', compact('brands','categories','products'));
    }
    public function sortByPrice(Request $request, $type)
    {
        $brands = Brand::all(); 
        $categories = Categories::all(); 
        // Kiểm tra loại sắp xếp được yêu cầu
        if ($type == 'asc') {
            $products = Product::orderBy('price')->paginate(10);
        } elseif ($type == 'desc') {
            $products = Product::orderByDesc('price')->paginate(10);
        } else {
            // Xử lý trường hợp không hợp lệ hoặc mặc định
            $products = Product::paginate(10);
        }

        // Trả về view với sản phẩm đã được sắp xếp
        return view('user.shop', compact('brands','categories','products'));
    }
    public function searchProduct(Request $request) {
        $search = $request->input('search');
        $brands = Brand::all(); 
        $categories = Categories::all(); 
        $wishlist = WishList::all();
        // Thực hiện truy vấn để tìm kiếm người dùng
        $products = Product::where('product_name', 'like', "%$search%")
                        ->orWhere('price', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('brand', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->paginate(9);
    
        return view('user.shop', compact('brands','categories','products','wishlist'));
    }
    public function goForgotPassword()
    {
        return view('auth.forgotpassword');
    }
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', compact('token'));
    }
    public function detailProduct($id){
        $wishlist = WishList::all();
        $product = Product::find($id);
        $product_image = ProductImage::where('product_id', $id)->get();
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->orwhere('brand_id', $product->brand_id) 
                                ->where('id', '!=', $id)    
                                ->limit(4) 
                                ->get();
        return view('user.detailproduct', compact('wishlist','product','product_image','relatedProducts'));
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
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:6',
        // ]);

        // $data = $request->all();
        // $check = $this->create($data);

        // return redirect("login")->withSuccess('Đăng kí thành công! Bạn có thể đăng nhập vào tài khoản');
        /////////////////////////////////////////////
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:6',
        // ]);
    
        // // Tạo mới user
        // $user = $this->create($request->all());
    
        // // Tạo token xác nhận
        // $token = Str::random(60); // Sử dụng Illuminate\Support\Str;
    
        // // Lưu token vào cột remember_token
        // $user->forceFill([
        //     'remember_token' => $token,
        // ])->save();
    
        // // Gửi email xác nhận
        // Mail::to($user->email)->send(new VerifyEmail($token));
    
        // // Chuyển hướng đến trang đăng nhập với thông báo
        // return redirect("login")->withSuccess('Đăng kí thành công! Vui lòng kiểm tra email để xác nhận.');
        //
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:6',
        //     'phone' => 'required|regex:/^[0-9]{1,15}$/',
        //     'img' => 'required',
        //     'address' => 'required|max:100',
        // ]);
    
        // $user = $this->create($request->only('name', 'email', 'password', 'phone', 'img', 'address'));
        // $token = Str::random(60);
    
        // $user->forceFill([
        //     'remember_token' => $token,
        // ])->save();
    
        // Mail::to($user->email)->send(new VerifyEmail($token));
    
        // return redirect("login")->withSuccess('Đăng kí thành công! Vui lòng kiểm tra email để xác nhận.');
        ///
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:6',
                'max:24',
                'regex:/^(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'phone' => 'required|regex:/^[0-9]{1,15}$/',
            'img' => 'required',
            'address' => 'required|max:100',
        ], [
            'name.required' => 'Trường tên là bắt buộc.',
            'email.required' => 'Trường email là bắt buộc.',
            'email.email' => 'Email phải là một địa chỉ email hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
            'password.required' => 'Trường mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max' => 'Mật khẩu tối đa có :max ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ cái viết hoa hoặc một số.',
            'phone.required' => 'Trường số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'img.required' => 'Trường ảnh là bắt buộc.',
            'address.required' => 'Trường địa chỉ là bắt buộc.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',
        ]);
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('user-image/images'), $imageName);
            
        }
         // Prepare data for user creation
        $data = $request->only('name', 'email', 'password', 'phone', 'address');
        $data['img'] = $imageName;

        // Create the user
        $user = $this->create($data);
        // $user = $this->create($request->only('name', 'email', 'password', 'phone', 'img', 'address'));
        $token = Str::random(60);
        $user->forceFill([
            'remember_token' => $token,
        ])->save();
        Mail::to($user->email)->send(new VerifyEmail($token));
        return redirect("login")->withSuccess('Đăng kí thành công! Vui lòng kiểm tra email để xác nhận.');
    }
    public function verifyEmail(Request $request)
    {
        // Tìm user theo token trong remember_token
        $user = User::where('remember_token', $request->token)->first();

        if ($user) {
            // Xác nhận email và cập nhật trường email_verified_at
            $user->email_verified_at = now();
            $user->save();

            // Chuyển hướng đến trang đăng nhập với thông báo
            return redirect("login")->withSuccess('Xác nhận email thành công! Bạn có thể đăng nhập vào tài khoản.');
        } else {
            // Token không hợp lệ
            return redirect("login")->withErrors('Token không hợp lệ.');
        }
    }
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'img' => $data['img'],
            'address' => $data['address'],
        ]);
    }

    public function dashboard()
    {
        if(Auth::check()){
            $products = Product::all();
            $banners = Banner::all();
            $brand = Brand::all();
            $categories = Categories::all();
            $wishlist = WishList::all();
            return view('user/dashboard', compact('products', 'banners','brand','categories','wishlist'));
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