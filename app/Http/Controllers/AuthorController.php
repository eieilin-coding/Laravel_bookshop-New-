<?php

namespace App\Http\Controllers;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
     public function index()
    {
        $authors = Author::latest()->paginate(8);
        return view('authors.index', compact('authors'));
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
