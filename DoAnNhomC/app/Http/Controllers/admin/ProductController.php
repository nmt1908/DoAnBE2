<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Brand;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index() {

    }
    public function adminListProduct()
    {
        $products = Product::with('category', 'brand')->paginate(5);
        // $products = Product::paginate(5);
        // $categories = Categories::all();

        // Lấy danh sách các brand từ bảng brands
        // $brands = Brand::all();
        return view('admin.product.listproduct', compact('products'));
    }
    // public function customAddProduct(Request $request) {
    //     $request->validate([
    //         'product_name' => 'required',
    //         'price' => 'required',
    //         'description' => 'required',
    //         'quantity' => 'required',
    //         'status' => 'required',
    //         'is_featured' => 'required',
    //         'image' => 'nullable',
    //         'category_id' => 'required',
    //         'brand_id' => 'required',

             
    //     ]);
    
    //     $productData = $request->except('image'); // Lấy dữ liệu sản phẩm trừ ảnh
    //     $product = Product::create($productData); // Tạo mới sản phẩm
    
        
    
    //     return redirect()->route('admin.listProduct')->withSuccess('Tạo sản phẩm thành công!');
    // }
    public function customAddProduct(Request $request) {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'status' => 'required',
            'is_featured' => 'required',
            'images.*' => 'nullable', // Điều kiện cho hình ảnh
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);
    
        // Tạo mới sản phẩm
        $product = Product::create($request->except('image'));
    
       // Lưu tất cả hình ảnh vào thư mục và tên gốc vào bảng product_images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $image->getClientOriginalName();
                
                // Kiểm tra xem tên file đã tồn tại trong bảng product_images hay chưa
                $existingImage = ProductImage::where('img', $imageName)->first();
                
                if (!$existingImage) {
                    // Nếu tên file chưa tồn tại, lưu ảnh vào thư mục và tên vào bảng product_images
                    $image->move(public_path('product-image'), $imageName);
                    $product->images()->create([
                        'img' => $imageName,
                        'sort_order' => 1, // Số thứ tự hình ảnh, nếu có
                    ]);
                } else {
                    // Nếu tên file đã tồn tại, chỉ cần lưu tên vào bảng product_images
                    $product->images()->create([
                        'img' => $imageName,
                        'sort_order' => 1, // Số thứ tự hình ảnh, nếu có
                    ]);
                }
            }
        }
    
        return redirect()->route('admin.listProduct')->withSuccess('Tạo sản phẩm thành công!');
    }
    public function create(array $data)
    {
        // Tạo mới sản phẩm
        $product = Product::create([
            'product_name' => $data['product_name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'quantity' => $data['quantity'],
            'is_featured' => $data['is_featured'],
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'],
            'status' => $data['status'],
        ]);
        
        
        return $product;
    }
    public function addProduct() {
        // Lấy danh sách các category từ bảng categories
        $categories = Categories::all();

        // Lấy danh sách các brand từ bảng brands
        $brands = Brand::all();

        // Trả về view 'admin.product.addproduct' và truyền danh sách các category và brand vào đó
        return view('admin.product.addproduct', compact('categories', 'brands'));
    }
    public function deleteProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $imagePath = public_path('product-image/' . $product->image);

    // Kiểm tra xem tệp ảnh tồn tại trước khi xóa
    if (realpath($imagePath) && !is_dir($imagePath)) {
        // Xóa tệp ảnh từ thư mục
        unlink($imagePath);
    }
        $product->delete();
        return redirect()->route('admin.listProduct')->with('success', 'Đã xóa sản phẩm thành công');
    }

    public function updateProduct(Request $request)
    {
        $product_id = $request->get('id');
        $product = Product::find($product_id);
        // Lấy danh sách các category từ bảng categories
        $categories = Categories::all();

        // Lấy danh sách các brand từ bảng brands
        $brands = Brand::all();
        return view('admin.product.updateproduct', ['product' => $product],compact('categories', 'brands'));
    }
    public function postUpdateProduct(Request $request) {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'status' => 'required',
            'is_featured' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);
    
        $input = $request->except(['_token', 'id']); // Loại bỏ các trường không cần thiết
    
        $product = Product::find($request->id);
    
        // Cập nhật thông tin sản phẩm
        $product->update($input);
    
        return redirect()->route('admin.listProduct')->withSuccess('Cập nhật sản phẩm thành công!');
    }
    
    public function searchProduct(Request $request){

        $search = $request->input('search');
        
        // Thực hiện truy vấn để tìm kiếm người dùng
        $products = Product::where('product_name', 'like', "%$search%")
                        ->orWhere('price', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        // ->orWhere('category_id', 'like', "%$search%")
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        // ->orWhere('brand_id', 'like', "%$search%")
                        ->orWhereHas('brand', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->paginate(5);
        
        return view('admin.product.listproduct', compact('products'));
    }
    
}
