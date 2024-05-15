<?php
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchUserController;
use App\Http\Controllers\CrudUserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\PagesController;
use App\Http\Controllers\WishListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard');
Route::get('mail', function () {
    Mail::to('ducmanh2017vtel@gmail.com')->send(new PasswordResetMail);
    // return view('user/dashboard');
});
Route::get('reset-password/{token}', [CustomAuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('reset-password', [CustomAuthController::class, 'resetPassword'])->name('reset-password.post');
Route::get('forgotpassword', [CustomAuthController::class, 'goForgotPassword'])->name('goforgotpassword');
Route::post('forgotpassword', [CustomAuthController::class, 'forgotPassword'])->name('forgotpassword');
Route::get('login', [CustomAuthController::class, 'index'])->name('login')->middleware('checkLogin');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
Route::get('/products/{id}', [CustomAuthController::class, 'detailProduct'])->name('detail.product');

Route::get('account', [PageController::class, 'accountProfile'])->name('accountProfile');
Route::get('updateaccount', [PageController::class, 'updateUser'])->name('user.updateUser');
Route::post('updateaccount', [PageController::class, 'postUpdateUser'])->name('user.postUpdateUser');

// pages 
Route::get('page/{slug}',[PageController::class,'page'])->name('page');


Route::get('change-password', [CustomAuthController::class, 'showChangePasswordForm'])->name('change-passwordPage');
Route::post('change-password', [CustomAuthController::class, 'changePassword'])->name('change-password');
Route::get('/cart',[CartController::class,'cart'])->name('user.cart');

Route::get('/orders',[OrderController::class,'orders'])->name('user.orders');
Route::get('/addOrders',[OrderController::class,'addOrders'])->name('user.addOrders');

Route::get('/detailOrders/{zip_order}',[OrderController::class,'detailOrders'])->name('user.orderDetail');
//pay
Route::get('/pays',[OrderController::class,'pays'])->name('user.checkOut');

Route::post('/cart/add', [CartController::class, 'addCart'])->name('cart.add2');
Route::get('/cart/total', [CartController::class, 'updateCart'])->name('total.product');
Route::delete('/cart/delete/{id}', [CartController::class, 'deleteCart'])->name('cart.delete');

Route::get('/verify-email', [CustomAuthController::class, 'verifyEmail'])->name('verify.email');
Route::get('shop', [CustomAuthController::class, 'showProductOnShop'])->name('goToShop');
Route::get('shop/by-brand/{brandId}', [CustomAuthController::class, 'showProductOnShopByBrand'])->name('products.by.brand');
Route::get('shop/by-category/{categoryId}', [CustomAuthController::class, 'showProductOnShopByCategory'])->name('products.by.category');
Route::get('shop/sort/{type}', [CustomAuthController::class, 'sortByPrice'])->name('products.sortbyprice');
Route::get('shop/search',[CustomAuthController::class,'searchProduct'])->name('searchProduct');

// wishlist 
Route::get('user/wishlist',[WishListController::class,'goToWishList'])->name('wishlist');
Route::get('/wishList/add', [WishListController::class, 'wishListAdd'])->name('wishList.add');

Route::delete('/wishlist/{id}', [WishListController::class, 'wishlistdelete'])->name('wishlist.delete');

Route::middleware(['auth', 'admin.access'])->group(function () {
    Route::get('admin/dashboard', [CustomAuthController::class, 'adminDashboard'])->name('admin.dashboard');

    // User routes
    Route::get('admin/user',[PageController::class,'adminListUser'])->name('admin.listuser');
    Route::get('admin/searchuser',[SearchUserController::class,'searchUser'])->name('admin.searchuser');
    Route::get('admin/adduser',[CrudUserController::class,'addUser'])->name('admin.adduser');
    Route::post('custom-adduser', [CrudUserController::class, 'customAddUser'])->name('admin.customAddUser');
    Route::delete('/delete-user/{id}', [CrudUserController::class, 'deleteUser'])->name('admin.deleteuser');
    Route::get('update', [CrudUserController::class, 'updateUser'])->name('admin.updateUser');
    Route::post('update', [CrudUserController::class, 'postUpdateUser'])->name('admin.postUpdateUser');
    //ADMIN CHANGE PASSWORD
    Route::get('changepassword', [CrudUserController::class, 'adminChangePassword'])->name('admin.changePassword');
    Route::post('changepassword', [CrudUserController::class, 'postAdminChangePassword'])->name('admin.postChangePassword');

    // Category routes
    Route::get('admin/categories',[CategoryController::class,'adminListCategory'])->name('admin.listcategories');
    Route::get('admin/addcategories',[CategoryController::class,'addCategories'])->name('admin.addcategories');
    Route::post('custom-addcategories', [CategoryController::class, 'customAddCategories'])->name('admin.customAddCategories');
    Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategories'])->name('admin.deletecategories');
    Route::get('update-categories', [CategoryController::class, 'updateCategories'])->name('admin.updateCategories');
    Route::post('update-categories', [CategoryController::class, 'postUpdateCategories'])->name('admin.postUpdateCategories');
    Route::get('admin/searchcategories',[CategoryController::class,'searchCategories'])->name('admin.searchCategories');

    // Brand routes
    Route::get('admin/brand',[BrandController::class,'adminListBrand'])->name('admin.listBrand');
    Route::get('admin/addbrand',[BrandController::class,'addBrand'])->name('admin.addBrand');
    Route::post('custom-addbrand', [BrandController::class, 'customAddBrand'])->name('admin.customAddBrand');
    Route::delete('/delete-brand/{id}', [BrandController::class, 'deleteBrand'])->name('admin.deleteBrand');
    Route::get('update-brand', [BrandController::class, 'updateBrand'])->name('admin.updateBrand');
    Route::post('update-brand', [BrandController::class, 'postUpdateBrand'])->name('admin.postUpdateBrand');
    Route::get('admin/searchbrand',[BrandController::class,'searchBrand'])->name('admin.searchBrand');

    //Brand products
    Route::get('admin/product',[ProductController::class,'adminListProduct'])->name('admin.listProduct');
    Route::get('admin/addproduct',[ProductController::class,'addProduct'])->name('admin.addProduct');
    Route::post('custom-addproduct', [ProductController::class, 'customAddProduct'])->name('admin.customAddProduct');
    Route::delete('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('admin.deleteProduct');
    Route::get('update-product', [ProductController::class, 'updateProduct'])->name('admin.updateProduct');
    Route::post('update-product', [ProductController::class, 'postUpdateProduct'])->name('admin.postUpdateProduct');
    Route::get('/product-images', [ProductController::class, 'getImage']);
    Route::get('admin/searchproduct',[ProductController::class,'searchProduct'])->name('admin.searchProduct');

    //Banner routes
    Route::get('admin/banner',[BannerController::class,'adminListBanner'])->name('admin.listbanner');
    Route::get('admin/addcbanner',[BannerController::class,'addBanner'])->name('admin.addbanner');
    Route::post('custom-addbanner', [BannerController::class, 'customAddBanner'])->name('admin.customaddbanner');
    Route::delete('/delete-banner/{id}', [BannerController::class, 'deleteBanner'])->name('admin.deletebanner');
    Route::get('update-banner', [BannerController::class, 'updateBanner'])->name('admin.updateBanner');
    Route::post('update-banner', [BannerController::class, 'postUpdateBanner'])->name('admin.postUpdateBanner');
    Route::get('admin/searchbanner',[BannerController::class,'searchBanner'])->name('admin.searchBanner');

    //Page router
    Route::get('admin/page',[PagesController::class,'adminListPage'])->name('admin.listpage');
    Route::get('admin/addcpage',[PagesController::class,'addPage'])->name('admin.addPage');
    Route::post('custom-addpage', [PagesController::class, 'customAddPage'])->name('admin.customaddpage');
    Route::delete('/delete-page/{id}', [PagesController::class, 'deletePage'])->name('admin.deletePage');
    Route::get('update-page', [PagesController::class, 'updatePage'])->name('admin.updatePage');
    Route::post('update-page', [PagesController::class, 'postUpdatePage'])->name('admin.postUpdatePage');
    Route::get('admin/searchpage',[PagesController::class,'searchPage'])->name('admin.searchPage');
    //Order route
    Route::get('admin/order',[OrderController::class,'goAdminOrder'])->name('admin.listorder');
    Route::post('/admin/orders/deliver/{zip_order}', [OrderController::class,'deliverOrder'])->name('admin.orders.deliver');

});
// Route::get('/', function () {
//     return view('user/dashboard');
// });
Route::get('/', [CustomAuthController::class, 'dashboardFirstLogin'])->name('dashboardFirstLogin');


