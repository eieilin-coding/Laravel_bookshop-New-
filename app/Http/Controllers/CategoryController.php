<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
         $categories = Category::all();
        if(request()->ajax())
        {
            return Datatables::of($categories)
                   ->addIndexColumn()
                   ->addColumn('action',function($row){
                        $btn = '';
                        $show = '';
                        $edit = "";

                        $edit = '<a href="'.route('categories.edit',[$row->id]).'" class="edit btn btn-primary btn-sm">Update</a>';
                        $btn .= $edit;

                        $show = '<a href="'.route('categories.delete',[$row->id]).'" class="show btn btn-danger btn-sm">Delete</a>';
                        $btn .= $show;

                        return $btn;
                   }) 

                   ->rawColumns(['action'])

                   ->make(true);    
        }
        return view('categories.index');       
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
    public function test()
    {   
        
        $categories = Category::all();
        if(request()->ajax())
        {
            return Datatables::of($categories)
                   ->addIndexColumn()
                   ->addColumn('action',function($row){
                        $btn = '';
                        $show = '';
                        $edit = "";

                        $edit = '<a href="'.route('categories.edit',[$row->id]).'" class="edit btn btn-danger btn-sm">edit</a>';
                        $btn .= $edit;

                        $show = '<a href="'.route('categories.show',[$row->id]).'" class="show btn btn-primary btn-sm">View</a>';
                        $btn .= $show;

                        return $btn;
                   }) 

                   ->rawColumns(['action'])

                   ->make(true);    
        }
        return view('categories.test');

       
    }
}
