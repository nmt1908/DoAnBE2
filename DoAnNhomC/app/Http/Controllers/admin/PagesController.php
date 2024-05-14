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
        $page = Page::findOrFail($id);
    
        $page->delete();
        return redirect()->back()->with('success', 'Page đã được xóa thành công');
    }

    public function updatePage(Request $request)
    {
        $page_id = $request->get('id');
        $page = Page::find($page_id);

        return view('admin.page.updatepage', ['page' => $page]);
    }
    public function postUpdatePage(Request $request) {
        $input = $request->all();
    
        // Kiểm tra dữ liệu
        $validator = validator([
            'name' => 'required',
            'slug' => 'required|unique:pages',
            'content' => 'required',
        ]);
    
        $page = Page::find($input['id']);
        $page->name = $input['name'];
        $page->slug = $input['slug'];
        $page->content = $input['content'];

    
        $page->save();
    
        return redirect()->route('admin.listpage')->withSuccess('Sửa page thành công!');
    }
    
    public function searchPage(Request $request){
        $search = $request->input('search');
        
        // Thực hiện truy vấn để tìm kiếm tên page
        $page = Page::where('name', 'like', "%$search%")
                        ->paginate(5);
        
        return view('admin.Page.listpage', compact('page'));
    }
}