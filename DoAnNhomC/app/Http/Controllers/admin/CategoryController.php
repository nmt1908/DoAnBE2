<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoryController extends Controller
{
    public function index() {

    }
    public function adminListCategory()
    {
        $categories = Categories::paginate(5);
        return view('admin.category.categories', compact('categories'));
    }
    public function createCategory() {

    }
    public function storeCategory() {

    }
    public function editCategory() {

    }
    public function updateCategory() {

    }
}
