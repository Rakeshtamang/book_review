@extends('layout.app')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layout.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header text-white">
                        My Reviews
                    </div>
                    <div class="card-body pb-0">
                        @include('layout.message')
                        <div class="d-flex justify-content-end align-items-center mb-3">
                            <form action="" method="GET">
                                @csrf

                                <div class="d-flex">
                                    <input type="text" name="keyword" class="form-control"
                                        value="{{ Request::get('keyword') }}" placeholder="Keyword" aria-label="Search"
                                        aria-describedby="basic-addon1" style="flex: 1;">
                                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                                    <a href="{{ route('myreviews.myReviews') }}" class="btn btn-secondary ms-2">Reset</a>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($review->isNotEmpty())
                                    @foreach ($review as $reviews)
                                        <tr>
                                            <td>{{ $reviews->book->name }}</td>
                                            <td>{{ $reviews->review }}</td>
                                            <td>{{ $reviews->rating }}</td>
                                            <td>
                                                @if ($reviews->status == 1)
                                                    <span class="text-success">Active</span>
                                                @else
                                                    <span class="text-danger">Block</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('myreviews.editMyReview', $reviews->id) }}"
                                                    class="btn btn-primary btn-sm"><i
                                                        class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <a href="" onclick="deleteMyReview({{ $reviews->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{ $review->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function deleteMyReview(id) {
            if (confirm('Are you sure you want to delete this review?')) {
                $.ajax({
                    url: '{{ route('myreviews.deleteMyReview', ['id' => '__id__']) }}'.replace('__id__', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert('Review deleted successfully');
                            window.location.reload(); // Reload the page to reflect the changes
                        } else {
                            alert('Failed to delete the review');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('An error occurred');
                    }
                });
            }
        }
    </script>
@endSection
