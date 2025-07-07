<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     //list=>index
    //  public function index()
    // {
    //     $data = Category::latest()->paginate(8);
    //     return view('categories.index', ['categories' => $data]);      
    // }

    public function index()
    {
        $categories = Category::latest()->paginate(8);
        return view('categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = request()->name;
        $category->save();

        return $category;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Category::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $category = Category::find($id);
        $category->name = request()->name;
        $category->save();

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return $category;
    }
}
