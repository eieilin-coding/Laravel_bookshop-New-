<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


use Symfony\Component\HttpFoundation\StreamedResponse;

class BookController extends Controller
{
    public function index()
    {       
        $discountBooks = Book::where('disc_price', '<', 6500)->take(5)->get();
        
        $featuredBooks = Book::where('is_featured', 1)->take(5)->get();
       
        $newBooks = Book::where('created_at', '>=', Carbon::now()->subWeeks(2))->take(5)->get();

        return view('books.index', [
            'discountBooks' => $discountBooks,
            'featuredBooks' => $featuredBooks,
            'newBooks' => $newBooks,
        ]);
    }

    public function discount()
    {
        $discount = Book::where('disc_price', '<', 6500)->paginate(8);
        return view('books.discountBooks', [
            'discount' => $discount,
        ]);
    }

    public function featured()
    {
        $featured = Book::where('is_featured', 1)->paginate(8);
        return view('books.featuredBooks', [
            'featured' => $featured,
        ]);
    }

    public function new()
    {
        $new = Book::where('created_at', '>=', Carbon::now()->subWeeks(2))->paginate(8);
        return view('books.newBooks', [
            'new' => $new,
        ]);
    }

    public function userview()
    {
        $categories = Category::all();
        $authors = Author::all();

        return view('layouts.userview', compact('categories', 'authors'));
    }

    public function explore(Request $request)
    {
        $categories = Category::all();
        $authors = Author::all();

        $query = Book::query()->with(['author', 'category']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('author', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $books = $query->paginate(8);

        return view('books.explore', compact('books', 'categories', 'authors'));
    }


    public function adminIndex()
    {
        $books = Book::with(['author', 'category'])->latest();
        if (request()->ajax()) {
            return Datatables::of($books)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $show = '';
                    $edit = "";
                    $delete = "";

                    $edit = '<a href="' . route('books.edit', [$row->id]) . '" class="edit btn btn-primary btn-md me-2">
                    <i class="fa-solid fa-pen-to-square"></i></a>';
                    $btn .= $edit;

                    $show = '<a href="' . route('books.showAdmin', [$row->id]) . '" class="show btn btn-info btn-md me-2 text-white">
                    <i class="fa-solid fa-eye"></i></a>';
                    $btn .= $show;

                    $delete = '<a href="' . route('books.delete', [$row->id]) . '" class="delete btn btn-danger btn-md"
                    onclick="return confirm(\'Are you sure you want to delete this book?\')">
                    <i class="fa-solid fa-trash"></i></a>';
                    $btn .= $delete;

                    return $btn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }
        return view('books.adminIndex');
    }

    public function show($id)
    {
        $data = Book::find($id);

        return view('books.show', [
            'book' => $data
        ]);
    }

    public function showAdmin($id)
    {
        $data = Book::find($id);

        return view('books.showAdmin', [
            'book' => $data
        ]);
    }
    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        return view('books.create', ['categories' => $categories, 'authors' => $authors]);
    }

    // Show the form to update a book
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        $authors = Author::all();
        return view('books.edit', ['book' => $book, 'categories' => $categories, 'authors' => $authors]);
    }


    public function store()
    {
        $validator = validator(request()->all(), [
            'author_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'publisher' => 'required',
            'published_date' => 'required',
            'description' => 'required',
            'file' => 'required|mimes:pdf|max:10240',
            'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048',

            //             $request->validate([
            //     'file' => 'required|mimes:pdf|max:20480', // 20MB
            //     'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048', // 2MB
            // ]);

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput(); // <- To get old input data ;
        }

        // Store the uploaded files in 'public' disk
        $photo = request()->file('photo');
        $file = request()->file('file');

        // Get original filenames
        $photoName = $photo->getClientOriginalName();
        $fileName = $file->getClientOriginalName();

        // Save them in the desired folders
        $photo->storeAs('photos/', $photoName, 'public');
        $file->storeAs('files/', $fileName, 'public');

        $book = new Book;
        $book->category_id = request()->category_id;
        $book->author_id = request()->author_id;
        $book->title = request()->title;
        $book->publisher = request()->publisher;
        $book->published_date = request()->published_date;
        $book->description = request()->description;
        $book->photo = $photoName;
        $book->file = $fileName;

        $book->save();

        return redirect('/books/adminIndex')->with('success', 'Book added successfully.');
    }

    public function delete($id)
    {
        $book = Book::find($id);

        $book->delete();
        return redirect('/books/adminIndex')->with('info', 'book deleted');
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validator = Validator($request->all(), [
            'author_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'publisher' => 'required',
            'published_date' => 'required',
            'description' => 'required',
            'photo' => 'image|mimes:jpg,png,jpeg|max:5120',
            'file' => 'mimes:pdf|max:20480',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update text fields
        $book->author_id = $request->author_id;
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->publisher = $request->publisher;
        $book->published_date = $request->published_date;
        $book->description = $request->description;

        // Replace photo if a new one is uploaded
        if ($request->hasFile('photo')) {
            $photoName = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('photos', $photoName, 'public');
            $book->photo = $photoName;
        }

        // Replace PDF if a new one is uploaded
        if ($request->hasFile('file')) {
            $pdfName = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('files', $pdfName, 'public');
            $book->file = $pdfName;
        }

        $book->save();

        return redirect('/books/adminIndex')->with('success', 'Book updated successfully.');
    }
    public function download($id)
    {
        $book = Book::findOrFail($id);
        $book->increment('download_count');
        $filePath = storage_path('app/public/files/' . $book->file); // If stored in storage/app/public

        if (!file_exists($filePath)) {
            return abort(404, 'File not found.');
        }

        // Return file download response
        return response()->download($filePath, basename($filePath));
    }

}
