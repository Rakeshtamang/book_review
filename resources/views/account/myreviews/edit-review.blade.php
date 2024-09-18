@extends('layout.app')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layout.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white">
                        Edit Reviews
                    </div>
                    <div class="card-body pb-3">
                        <form action="{{ route('account.reviews.updateReview', $review->id) }}" method="POST">

                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Book Name</label>
                                <div>
                                    <strong> {{ $review->book->name }}</strong>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="review" class="form-label">Review</label>
                                <textarea placeholder="Review" class="form-control @error('review') is-invalid @enderror" name="review" id="review"
                                    cols="5" rows="5" style="max-width: 100%; max-height: 200px; resize: none;">
    {{ old('review', $review->review) }}
</textarea>

                                @error('review')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <select name="rating" id="rating"
                                    class="form-control @error('status') is-invalid @enderror">
                                    <option value="1"{{ $review->rating == 1 ? ' selected' : '' }}>
                                        1</option>
                                    <option value="2"{{ $review->rating == 2 ? ' selected' : '' }}>2
                                    </option>
                                    <option value="3"{{ $review->rating == 3 ? ' selected' : '' }}>3
                                    </option>
                                    <option value="4"{{ $review->rating == 4 ? ' selected' : '' }}>4
                                    </option>
                                    <option value="5"{{ $review->rating == 5 ? ' selected' : '' }}>5
                                    </option>
                                </select>
                                @error('status')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
