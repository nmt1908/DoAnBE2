<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index() {

    }
    public function adminListBrand()
    {
        $brands = Brand::paginate(5);
        return view('admin.brand.list', compact('brands'));
    }
    public function customAddBrand(Request $request) {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'status' => 'required',
            'image' => 'required', // Thêm validation cho ảnh
        ]);
    
        $data = $request->all();
    
        // Truy vấn dữ liệu từ model Categories
        $categories = new Brand();
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của ảnh
            // Kiểm tra xem có ảnh đã được tải lên trước đó hay không
            if (!empty($categories->image)) {
                // Nếu có, sử dụng lại ảnh đã được tải lên trước đó
                $data['image'] = $categories->image;
            } else {
                // Nếu không có, xử lý tệp tin ảnh mới
                $image->move(public_path('brand-image/images'), $imageName);
                $data['image'] = $imageName;
            }
        }
    
        $check = $this->create($data);
        
        return redirect()->route('admin.listBrand')->withSuccess('Tạo brand thành công!');
    }
    public function create(array $data)
    {
        return Brand::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'status' => $data['status'],
            'image' => isset($data['image']) ? $data['image'] : null, // Lưu tên ảnh vào cột image
        ]);
    }
    public function addBrand() {
        return view('admin.brand.add');
    }
    public function deleteBrand(Request $request, $id)
    {
       
    }

    public function updateBrand(Request $request)
    {
       
    }
    public function postUpdateBrand(Request $request) {
       
    }
    
    public function searchBrand(Request $request){

    }
}
