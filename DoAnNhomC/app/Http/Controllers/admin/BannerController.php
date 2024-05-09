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
}
