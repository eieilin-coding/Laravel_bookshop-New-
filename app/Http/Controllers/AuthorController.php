<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller; // ✅ Important
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class AuthorController extends Controller implements HasMiddleware
{
      public function __construct()
    {
        $this->middleware('auth'); // All routes require login
    }
     public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['index', 'delete']),
            new Middleware('auth', only: ['index', 'delete']),
        ];
    }

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

                    $edit = '<button type="button" class="editAuthor btn btn-primary btn-md"  data-bs-toggle="modal" 
                            data-bs-target="#updateAuthorModal"  data-id="' . $row->id . '"   data-name="' . htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8') . '">
                            <i class="fa fa-edit"></i> </button>';

                    $btn .= $edit;


                    $delete = '<a href="' . route('authors.delete', [$row->id]) . '" class="deleteAuthor btn btn-danger btn-md">
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
