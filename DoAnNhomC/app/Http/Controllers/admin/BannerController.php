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
    public function deleteBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $imagePath = public_path('banner-image' . $banner->img_banner);

    // Kiểm tra xem tệp ảnh tồn tại trước khi xóa
    if (file_exists($imagePath)) {
        // Xóa tệp ảnh từ thư mục
        unlink($imagePath);
    }
        $banner->delete();
        return redirect()->route('admin.listbanner')->with('success', 'Banner đã được xóa thành công');
    }
    public function updateBanner(Request $request)
    {
        $banner_id = $request->get('id');
        $banner = Banner::find($banner_id);

        return view('admin.banner.updatebanner', ['banner' => $banner]);
    }
    public function postUpdateBanner(Request $request) {
        $input = $request->all();
    
        // Kiểm tra dữ liệu
        $request->validate([
            'name' => 'required|unique:banners,name_banner,'.$input['id'], // Thêm 'id' của banner hiện tại vào rule để loại trừ nó khi kiểm tra sự duy nhất
            'description' => 'required',
            'status' => 'required',
            'image' => 'nullable', // Kiểm tra xem ảnh có đúng định dạng không
        ]);
    
        $banner = Banner::find($input['id']);
        $banner->name_banner = $input['name'];
        $banner->description_banner = $input['description'];
        $banner->status = $input['status'];
    
        // Kiểm tra xem người dùng đã cung cấp một tệp tin ảnh mới hay không
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của ảnh
            $image->move(public_path('banner-image'), $imageName);
            $banner->img_banner = $imageName;
        } elseif (empty($input['image'])) {
            // Nếu không có tệp tin ảnh mới được tải lên và không có giá trị trong trường img, 
            // tức là người dùng không muốn thay đổi ảnh, sử dụng ảnh cũ.
            $banner->img_banner = $banner->img_banner;
        }
    
        $banner->save();
    
        return redirect()->route('admin.listbanner')->withSuccess('Sửa banner thành công!');
    }
}
