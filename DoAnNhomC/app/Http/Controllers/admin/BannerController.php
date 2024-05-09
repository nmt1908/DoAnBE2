<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    
    public function adminListBanner(){
        $banner = Banner::paginate(5);
        return view('admin.banner.listbanner', compact('banner'));
    }
    public function customAddBanner(Request $request) {
        $request->validate([
            'name' => 'required|unique:banners,name_banner',
            'description' => 'required',
            'status' => 'required',
            'image' => 'required', // Thêm validation cho ảnh
        ]);
        
        $data = $request->all();
    
        // Truy vấn dữ liệu từ model Categories
        $banner = new Banner();
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của ảnh
            // Kiểm tra xem có ảnh đã được tải lên trước đó hay không
            if (!empty($categories->image)) {
                // Nếu có, sử dụng lại ảnh đã được tải lên trước đó
                $data['image'] = $categories->image;
            } else {
                // Nếu không có, xử lý tệp tin ảnh mới
                $image->move(public_path('banner-image'), $imageName);
                $data['image'] = $imageName;
            }
        }
    
        $check = $this->create($data);
        
        // return redirect()->route('admin.listbanner')->withSuccess('Tạo banner thành công!');
        if ($check) {
            return redirect()->route('admin.listbanner')->withSuccess('Tạo banner thành công!');
        } else {
            return redirect()->back()->withErrors('Không thể tạo banner mới. Vui lòng thử lại.');
        }
    }
    public function create(array $data)
    {
        return Banner::create([
            'name_banner' => $data['name'],
            'description_banner' => $data['description'],
            'status' => $data['status'],
            'img_banner' => isset($data['image']) ? $data['image'] : null, // Lưu tên ảnh vào cột image
        ]);
    }
    public function addBanner() {
        return view('admin.banner.addbanner');
    }
}
