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
}
