<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\StreamedResponse;

class BookController extends Controller
{
    public function index()
    {

        //     // Latest books (sorted by newest first)
        // $latestBooks = Book::latest()->take(4)->get(); // Adjust `take(4)` as needed

        // // Discounted books (where discount > 0)
        // $discountedBooks = Book::where('discount', '>', 0)->get();

        // // Featured books (optional, if needed)
        // $featuredBooks = Book::where('is_featured', true)->get(); // Requires a `is_featured` column

        // return view('books.index1', [
        //     'latestBooks' => $latestBooks,
        //     'discountedBooks' => $discountedBooks,
        //     'featuredBooks' => $featuredBooks, // Optional
        // ]);

        $data = Book::get();

        $latestBooks = Book::latest()->get();

        return view('books.index', [
            'books' => $data,
            'latestBooks' => $latestBooks,
        ]);


        // // Get only active (non-archived) books
        // $activeBooks = Book::all();

        // // Include archived books
        // $allBooksIncludingArchived = Book::withTrashed()->get();

        // // Get only archived books
        // $archivedBooks = Book::onlyTrashed()->get();
    }

    public function adminInd()
    {
        $books = (Book::with(['author', 'category'])->withTrashed());
        if (request()->ajax()) {
            return DataTables::of($books)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->trashed() ?
                        '<span class="badge badge-danger">Archived</span>' :
                        '<span class="badge badge-success">Active</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if ($row->trashed()) {
                        $btn .= '<a href="' . route('books.restore', $row->id) . '" class="btn btn-sm btn-info">Restore</a> ';
                    } else {
                        $btn .= '<a href="' . route('books.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a> ';
                        $btn .= '<a href="' . route('books.archive', $row->id) . '" class="btn btn-sm btn-warning">Archive</a> ';
                    }
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('books.adminInd');
    }

    public function archive($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Book archived successfully']);
        }

        return redirect()->back()->with('success', 'Book archived successfully');
    }

    public function restore($id)
    {
        $book = Book::withTrashed()->findOrFail($id);
        $book->restore();

        if (request()->ajax()) {
            return response()->json(['message' => 'Book restored successfully']);
        }

        return redirect()->back()->with('success', 'Book restored successfully');
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

                    $edit = '<a href="' . route('books.edit', [$row->id]) . '" class="edit btn btn-primary btn-md">
                    <i class="fa-solid fa-pen-to-square"></i></a>';
                    $btn .= $edit;

                    $show = '<a href="' . route('books.show', [$row->id]) . '" class="show btn btn-info btn-md">
                    <i class="fa-solid fa-eye"></i></a>';
                    $btn .= $show;

                    $delete = '<a href="' . route('books.delete', [$row->id]) . '" class="delete btn btn-danger btn-md">
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
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
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

        // Update download count
        $book->increment('download_count');

        // Assume the 'file' column stores the relative path like 'books/mybook.pdf'
        $filePath = storage_path('app/public/files/' . $book->file); // If stored in storage/app/public

        if (!file_exists($filePath)) {
            return abort(404, 'File not found.');
        }

        // Return file download response
        return response()->download($filePath, basename($filePath));
    }
}
