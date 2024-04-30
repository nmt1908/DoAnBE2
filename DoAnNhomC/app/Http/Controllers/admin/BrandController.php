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
       
    }
    public function create(array $data)
    {
       
    }
    public function addBrand() {
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
