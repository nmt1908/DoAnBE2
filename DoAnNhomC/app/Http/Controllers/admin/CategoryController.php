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
        $categories->delete();
        return redirect()->back()->with('success', 'Người dùng đã được xóa thành công');
    }

    public function editCategory() {

    }
    public function updateCategory() {

    }
}
