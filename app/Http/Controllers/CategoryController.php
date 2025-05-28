<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $req)
    {
        $name = $req->query('name');
        $order_by = $req->query('order_by', 'created_at');
        $sort = $req->query('sort', 'asc');

        $categories = Category::when($name, function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })->withCount('items')->orderBy($order_by, $sort)->paginate(10);

        return view('category.index', compact('categories'));
    }

    public function addCategory(CategoryRequest $req)
    {
        Category::create($req->only(['name']));
        return redirect()->back()->with('success', 'New category "' . $req->name . '" created');
    }

    public function updateCategory(CategoryRequest $req, Category $cat)
    {
        // dd($req->all());
        if ($req->name == $req->old_name) {
            return redirect()->back()->with('info', 'No change were made');
        }
        Category::where($cat->getKeyName(), $req->id)->update($req->only(['name']));
        return redirect()->back()->with('success', 'Category updated to: "' . $req->name . '"');
    }

    public function deleteCategory(Request $req, Category $cat)
    {
        Category::where($cat->getKeyName(), $req->id)->delete();
        return redirect()->back()->with('success', 'Category deleted');
    }
}
