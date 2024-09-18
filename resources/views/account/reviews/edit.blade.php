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
                        <form action="{{ route('account.reviews.updateReview', $review->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
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
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                    <option value="1"{{ old('status', $review->status) == 1 ? ' selected' : '' }}>
                                        Active</option>
                                    <option value="0"{{ old('status', $review->status) == 0 ? ' selected' : '' }}>Block
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
