<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    //show lsiting page
    public function index(Request $request)
    {
        $books = Book::orderBy('id', 'desc');

        if (!empty($request->keyword)) {
            $books->where('name', 'like', '%' . $request->keyword . '%');
        }

        $books = $books->paginate(5);

        return view('book.list', ['books' => $books]);
    }

    // this method will show create book page
    public function create()
    {
        return view('book.create');
    }
    //this method will store book in database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for image
        ]);

        if ($validator->fails()) {
            return redirect()->route('book.create')->withInput()->withErrors($validator);
        }

        $book = new Book();
        $book->name = $request->title;
        $book->author = $request->author;
        $book->description = $request->description; // Assuming you have a description field in your form
        $book->status = $request->status;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/book'), $image_name);
            $book->image = $image_name;
        }

        $book->save();

        return redirect()->route('book-list.index')->with('success', 'Book created successfully');
    }

    //show edit book page
    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('book.edit', ['book' => $book]);
    }
    public function update($id, Request $request)
    {
        $book = Book::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for image
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('book.edit', $book->id)
                ->withInput()
                ->withErrors($validator);
        }

        $book->name = $request->title;
        $book->author = $request->author;
        $book->description = $request->description; // Assuming you have a description field in your form
        $book->status = $request->status;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // This will delete the old book image
            File::delete(public_path('uploads/book/' . $book->image));
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/book'), $image_name);
            $book->image = $image_name;
        }

        $book->save();

        return redirect()->route('book-list.index')->with('success', 'Book updated successfully');
    }

    public function delete(Request $request)
    {
        $book = Book::findOrFail($request->id);

        if ($book==null) {
            session()->flash('error', 'Book not found');
            return response()->json(['status' => false, 'message' => 'Book not found']);
        }

        File::delete(public_path('uploads/book/' . $book->image));
        $book->delete();
session()->flash('success', 'Book Deleted successfully');
        // Corrected: Removed extra closing parenthesis
        return response()->json(['status' => true, 'message' => 'Book deleted successfully']);
    }
}
