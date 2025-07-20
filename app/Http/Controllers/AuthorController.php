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
        if (request()->ajax()) {
            return Datatables::of($authors)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $del = '';
                    $edit = "";

                    $edit = '<button type="button" class="editAuthor btn btn-primary btn-md me-2"  data-bs-toggle="modal" 
                            data-bs-target="#updateAuthorModal"  data-id="' . $row->id . '"   data-name="' . htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8') . '">
                            <i class="fa fa-edit"></i> </button>';

                    $btn .= $edit;


                    $delete = '<a href="' . route('authors.delete', [$row->id]) . '" class="deleteAuthor btn btn-danger btn-md"
                    onclick="return confirm(\'Are you sure you want to delete this author?\')">
                    <i class="fa-solid fa-trash"></i></a>';
                    $btn .= $delete;

                    return $btn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }
        return view('authors.index');
    }

    public function store()
    {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255|unique:authors,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $author = new Author;
        $author->name = request()->name;
        $author->save();

        return redirect()->route('authors.index');
    }

    public function update($id)
    {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255|unique:authors,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $author = Author::find($id);
        $author->name = request()->name;
        $author->save();

        return redirect()->route('authors.index');
    }

    public function delete($id)

    {
        $author = author::find($id);
        $author->delete();
        return redirect()->route('authors.index');
    }
}
