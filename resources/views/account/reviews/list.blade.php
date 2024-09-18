@extends('layout.app')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layout.sidebar')
            </div>
            <div class="col-md-9">
                @include('layout.message')

                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        My Reviews
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-end align-items-center mb-3">

                            <form action="" method="GET">
                                <div class="d-flex">
                                    <input type="text" name="keyword" class="form-control" placeholder="Keyword"
                                        aria-label="Search" aria-describedby="basic-addon1" style="flex: 1;"
                                        value="{{ old('keyword') }}"> <!-- Retain the search keyword -->
                                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                                    {{-- <a href="{{ route('account.reviews') }}" class="btn btn-secondary ms-2">Reset</a> --}}
                                </div>
                            </form>


                        </div>
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Created At</th>
                                    <th>Status</th>

                                    <th width="100">Action</th>
                                </tr>
                            <tbody>
                                @if ($reviews->isNotEmpty())
                                    @foreach ($reviews as $review)
                                        <tr>
                                            <td>{{ $review->book->name }}</td>
                                            <td>{{ $review->review }}<br /><strong>{{ $review->user->name }}</strong></td>
                                            <td>{{ $review->rating }}</td>
                                            <td>{{ \Carbon\Carbon::parse($review->created_at)->format('d M,Y') }}</td>

                                            <td>
                                                @if ($review->status == 1)
                                                    <span class="text-success">Active</span>
                                                @else
                                                    <span class="text-danger">Block</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('account.reviews.myReviews', $review->id) }}"
                                                    class="btn btn-primary btn-sm"><i
                                                        class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <a href="#" onclick="deleteReview({{ $review->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif


                            </tbody>
                            </thead>
                        </table>
                        {{ $reviews->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function deleteReview(id) {
            if (confirm('Are you sure you want to delete?')) {
                $.ajax({
                    url: '{{ route('account.reviews.deleteReview') }}',
                    data: {
                        id: id
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            // window.location.href = '{{ route('account.reviews') }}';
                        } else {
                            alert('Error: Review could not be deleted.');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while trying to delete the review.');
                    }
                });
            }
        }
    </script>
@endsection
