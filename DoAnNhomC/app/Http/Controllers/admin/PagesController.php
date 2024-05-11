<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PagesController extends Controller
{
    public function adminListPage()
    {
        $page = Page::paginate(5);
        return view('admin.Page.listpage', compact('page'));
    }
    public function customAddPage(Request $request) {
       
    }
    public function create(array $data)
    {
       
    }
    public function addPage() {
       
    }
    public function deletePage(Request $request, $id) {

    }

    public function updatePage(Request $request)
    {
      
    }
    public function postUpdatePage(Request $request) {
       
    }
    
    public function searchPage(Request $request){

    }
}
