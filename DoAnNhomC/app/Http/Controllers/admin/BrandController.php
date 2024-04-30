<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index() {

    }
    public function adminListBrand(){
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
    public function create(array $data){
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
    public function deleteBrand(Request $request, $id){
        $brands = Brand::findOrFail($id);
        $imagePath = public_path('brand-image/images/' . $brands->image);

    // Kiểm tra xem tệp ảnh tồn tại trước khi xóa
    if (file_exists($imagePath)) {
        // Xóa tệp ảnh từ thư mục
        unlink($imagePath);
    }
        $brands->delete();
        return redirect()->back()->with('success', 'Người dùng đã được xóa thành công');
    }

    public function updateBrand(Request $request)
    {
        $brands_id = $request->get('id');
        $brands = Brand::find($brands_id);

        return view('admin.brand.update', ['brand' => $brands]);
    }
    public function postUpdateBrand(Request $request) {
        $input = $request->all();
    
        // Kiểm tra dữ liệu
        $validator = validator([
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'status' => 'required',
            'image' => 'required|image', // Kiểm tra xem ảnh có đúng định dạng không
        ]);
    
        $brands = Brand::find($input['id']);
        $brands->name = $input['name'];
        $brands->slug = $input['slug'];
        $brands->status = $input['status'];
    
        // Kiểm tra xem người dùng đã cung cấp một tệp tin ảnh mới hay không
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của ảnh
            $image->move(public_path('category-image/images'), $imageName);
            $brands->image = $imageName;
        } elseif (empty($input['image'])) {
            // Nếu không có tệp tin ảnh mới được tải lên và không có giá trị trong trường img, 
            // tức là người dùng không muốn thay đổi ảnh, sử dụng ảnh cũ.
            $brands->image = $brands->image;
        }
    
        $brands->save();
    
        return redirect()->route('admin.listBrand')->withSuccess('Sửa brand thành công!');
    }
    
    public function searchBrand(Request $request){
        $search = $request->input('search');
        
        // Thực hiện truy vấn để tìm kiếm người dùng
        $brands = Brand::where('name', 'like', "%$search%")
                        ->orWhere('slug', 'like', "%$search%")
                        ->paginate(5);
        
        return view('admin.brand.list', compact('brands'));
    }
}
