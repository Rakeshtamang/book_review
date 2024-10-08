@extends('layout.app')

@section('main')
    <div class="container">
        <div class="row my-5">
            @include('layout.message')
            <div class="col-md-3">
                @include('layout.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header text-white">
                        Books
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="{{ route('book.create') }}" class="btn btn-primary">Add Book</a>

                            <form action="" method="GET">
                                <div class="d-flex">
                                    <input type="text" name="keyword" class="form-control" placeholder="Keyword"
                                        aria-label="Search" aria-describedby="basic-addon1" style="flex: 1;">
                                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                                    <a href="{{ route('book-list.index') }}" class="btn btn-secondary ms-2">Reset</a>
                                </div>
                            </form>

                        </div>
                        <table class="table table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($books->isNotEmpty())
                                    @foreach ($books as $book)
                                        <tr>
                                            <td>{{ $book->name }}</td>
                                            <td>{{ $book->author }}</td>
                                            <td>3.0 (3 Reviews)</td>
                                            <td>
                                                @if ($book->status == 1)
                                                    <span class="text-success">Active</span>
                                                @else
                                                    <span class="text-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm"><i
                                                        class="fa-regular fa-star"></i></a>
                                                <a href="{{ route('book.edit', $book->id) }}"
                                                    class="btn btn-primary btn-sm"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>
                                                <a href="#" onClick="deleteBook({{ $book->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Books Not Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @if ($books->isNotEmpty())
                            {{ $books->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteBook(id) {
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: "{{ route('book.delete', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href = '{{ route('book-list.index') }}';
                    }
                });
            }
        }
    </script>
@endsection
