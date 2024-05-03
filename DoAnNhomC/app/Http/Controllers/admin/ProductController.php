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
        $products = Product::paginate(5);
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
    public function deleteCategories(Request $request, $id)
    {
        $categories = Categories::findOrFail($id);
        $imagePath = public_path('category-image/images/' . $categories->image);

    // Kiểm tra xem tệp ảnh tồn tại trước khi xóa
    if (file_exists($imagePath)) {
        // Xóa tệp ảnh từ thư mục
        unlink($imagePath);
    }
        $categories->delete();
        return redirect()->back()->with('success', 'Categories đã được xóa thành công');
    }

    public function updateCategories(Request $request)
    {
        $category_id = $request->get('id');
        $category = Categories::find($category_id);

        return view('admin.category.update', ['category' => $category]);
    }
    public function postUpdateCategories(Request $request) {
        $input = $request->all();
    
        // Kiểm tra dữ liệu
        $validator = validator([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'status' => 'required',
            'image' => 'required|image', // Kiểm tra xem ảnh có đúng định dạng không
        ]);
    
        $category = Categories::find($input['id']);
        $category->name = $input['name'];
        $category->slug = $input['slug'];
        $category->status = $input['status'];
    
        // Kiểm tra xem người dùng đã cung cấp một tệp tin ảnh mới hay không
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của ảnh
            $image->move(public_path('category-image/images'), $imageName);
            $category->image = $imageName;
        } elseif (empty($input['image'])) {
            // Nếu không có tệp tin ảnh mới được tải lên và không có giá trị trong trường img, 
            // tức là người dùng không muốn thay đổi ảnh, sử dụng ảnh cũ.
            $category->image = $category->image;
        }
    
        $category->save();
    
        return redirect()->route('admin.listcategories')->withSuccess('Sửa categories thành công!');
    }
    
    public function searchCategories(Request $request){

        $search = $request->input('search');
        
        // Thực hiện truy vấn để tìm kiếm người dùng
        $categories = Categories::where('name', 'like', "%$search%")
                        ->orWhere('slug', 'like', "%$search%")
                        ->paginate(5);
        
        return view('admin.category.categories', compact('categories'));
    }
}
