<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoryController extends Controller
{
    public function index() {

    }
    public function adminListCategory()
    {
        $categories = Categories::paginate(5);
        return view('admin.category.categories', compact('categories'));
    }
    public function customAddCategories(Request $request) {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'status' => 'required',
            'image' => 'required', // Thêm validation cho ảnh
        ]);
    
        $data = $request->all();
    
        // Truy vấn dữ liệu từ model Categories
        $categories = new Categories();
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của ảnh
            // Kiểm tra xem có ảnh đã được tải lên trước đó hay không
            if (!empty($categories->image)) {
                // Nếu có, sử dụng lại ảnh đã được tải lên trước đó
                $data['image'] = $categories->image;
            } else {
                // Nếu không có, xử lý tệp tin ảnh mới
                $image->move(public_path('category-image/images'), $imageName);
                $data['image'] = $imageName;
            }
        }
    
        $check = $this->create($data);
        
        return redirect()->route('admin.listcategories')->withSuccess('Tạo categories thành công!');
    }
    public function create(array $data)
    {
        return Categories::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'status' => $data['status'],
            'image' => isset($data['image']) ? $data['image'] : null, // Lưu tên ảnh vào cột image
        ]);
    }
    public function addCategories() {
        return view('admin.category.addcategories');
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
        return redirect()->back()->with('success', 'Người dùng đã được xóa thành công');
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
    
}