<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        if (request()->ajax()) {
            return Datatables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $delete = '';
                    $edit = "";

                    $edit = '<button type="button" data-id="'.$row->id.'" class="editCategory btn btn-primary btn-md">
                        <i class="fa fa-edit"></i></button>';
                    $btn .= $edit;

                    $delete = '<button type="button" data-id="'.$row->id.'" class="deleteCategory btn btn-danger btn-md">
                    <i class="fa fa-trash"></i></button>';
                    $btn .= $delete;

                    return $btn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }
        return view('categories.index');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $request->name]);
        return response()->json(['success' => true, 'message' => 'Category created successfully']);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category = Category::find($id);
        $category->update(['name' => $request->name]);
        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted']);
    }
}
