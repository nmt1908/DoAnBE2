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
        $request->validate([
            'name' => 'required|unique:pages,name',
            'slug' => 'required',
            'content' => 'required',
        ]);
        
        $data = $request->all();
    
        $check = $this->create($data);
        

        if ($check) {
            return redirect()->route('admin.listpage')->withSuccess('Tạo page thành công!');
        } else {
            return redirect()->back()->withErrors('Không thể tạo page mới. Vui lòng thử lại.');
        }
    }
    public function create(array $data)
    {
        return Page::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'content' => $data['content'],
        ]);
    }
    public function addPage() {
       return view('admin.page.addpage');
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
