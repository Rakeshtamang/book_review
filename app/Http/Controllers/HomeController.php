<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Book; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;// Import the Book model class

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Start with the query builder
        $query = Book::orderBy('id', 'desc');

        // Apply the search filter if a keyword is provided
        if (!empty($request->keyword)) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Filter books to only include those with status = 1
        $query->where('status', 1);

        // Execute the query and get the results with pagination
        $kitab = $query->paginate(4); // Paginate with 3 items per page

        return view('home', compact('kitab')); // Pass $kitab to the view
    }
    public function detail($id)
    {
        $book=Book::with( ['reviews.user','reviews'=>function($query)
        {
$query->where('status', 1);
        }])->findOrFail($id);
        if($book->status==0){
            abort(404);
        }
        $relatedBooks=Book::where('status', 1)->where('id', '!=', $id)->take(3)->inRandomOrder()->get();
      
        return view('book-detail', ['book' => $book, 'relatedBooks' => $relatedBooks]);
    }
    public function saveReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'review' => 'required|min:10',
            'rating' => 'required|in:1,2,3,4,5',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors'=> $validator->errors()
            ]);
        }
        $countReview=Review::where('book_id', $request->book_id)->where('user_id', Auth::user()->id)->count();
        if($countReview>0){
           session()->flash('error', 'Review already submitted');
        }
        $review=new Review();
        $review->review=$request->review;
        $review->rating=$request->rating;
        $review->user_id=Auth::user()->id;

        $review->book_id=$request->book_id;
        $review->save();
        session()->flash('success', 'Review Submitted successfully');
        return response()->json([
            'status' => true,
            'message'=> 'Review Su successfully'
        ]);

    }
}
