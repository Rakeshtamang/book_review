<?php 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with('book', 'user')->orderBy('id', 'desc');

        if (!empty($request->keyword)) {
            $reviews = $reviews->where('review', 'like', '%' . $request->keyword . '%');
        }

        $reviews = $reviews->paginate(5);
        return view('account.reviews.list', ['reviews' => $reviews]);
    }
    public function edit(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        return view('account.reviews.edit', ['review' => $review]);
    }
    public function updateReview(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'review'=>'required',
            'status'=>'required'
            
        ]);
        if($validator->fails()){
            return redirect()->route('account.reviews.edit', ['id'=> $review->id])->withInput()->withErrors($validator);
        }

        $review->review = $request->review;
        $review->status = $request->status;
        $review->save();
        session()->flash('success','Review Updated Sucessfully.');
        // return redirect()->route('account.reviews');
    }
   public function deleteReview(Request $request)
{
  $id = $request->id;
  $review = Review::findOrFail($id);

  if ($review == null) {
    session()->flash('error', 'Review Not Found');
    return response()->json([
      'status' => false,
    ]);
  }

  $review->delete();
  session()->flash('success', 'Review Deleted Successfully');
  return response()->json([
    'status' => true,
  ]);
}

}
