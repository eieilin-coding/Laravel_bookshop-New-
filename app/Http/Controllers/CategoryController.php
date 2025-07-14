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

                    // $edit = '<button type="button"  data-bs-toggle="modal" data-bs-target="#updateCategoryModal" data-id="' . $row->id . '" data-name="' . $row->name . '" class="editCategory btn btn-primary btn-md">
                    //     <i class="fa fa-edit"></i></button>';

                    $edit = '<button type="button" class="editCategory btn btn-primary btn-md"  data-bs-toggle="modal" 
                            data-bs-target="#updateCategoryModal"  data-id="' . $row->id . '"   data-name="' . htmlspecialchars($row->name, ENT_QUOTES) . '">
                            <i class="fa fa-edit"></i> </button>';
                    $btn .= $edit;


                    $delete = '<a href="' . route('categories.delete', [$row->id]) . '" class="delete btn btn-danger btn-md">
                    <i class="fa-solid fa-trash"></i></a>';
                    $btn .= $delete;

                    return $btn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }
        return view('categories.index');
    }

    public function store()
    {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $category = new Category;
        $category->name = request()->name;
        $category->save();

        return redirect()->route('categories.index');
    }

    public function update($id)
    {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $category = Category::find($id);
        $category->name = request()->name;
        $category->save();

        return redirect()->route('categories.index');
    }

    public function delete($id)

    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.index');
    }
}
