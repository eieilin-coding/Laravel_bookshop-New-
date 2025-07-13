<?php

namespace App\Http\Controllers;
use App\Models\Author;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class AuthorController extends Controller
{
     public function index()
    {
         $authors = Author::all();
        if(request()->ajax())
        {
            return Datatables::of($authors)
                   ->addIndexColumn()
                   ->addColumn('action',function($row){
                        $btn = '';
                        $del = '';
                        $edit = "";

                        $edit = '<a href="'.route('authors.edit',[$row->id]).'" class="edit btn btn-primary btn-md"><i class="fa-solid fa-pen-to-square"></i></a>';
                        $btn .= $edit;

                        $del = '<a href="'.route('authors.delete',[$row->id]).'" class="del btn btn-danger btn-md"><i class="fa-solid fa-trash"></i></a>';
                        $btn .= $del;

                        return $btn;
                   }) 

                   ->rawColumns(['action'])

                   ->make(true);    
        }
        return view('authors.index');

    }

    // 2. Show the form for creating a new author
    public function create()
    {
        return view('authors.create');
    }

    // 3. Store a newly created author in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Author::create([
            'name' => $request->name,
        ]);

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    // 4. Display the specified author
    public function show(Author $author)
    {
        return view('authors.show', compact('author'));
    }

    // 5. Show the form for editing the specified author
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    // 6. Update the specified author in storage
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->update([
            'name' => $request->name,
        ]);

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    // 7. Remove the specified author from storage
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}
