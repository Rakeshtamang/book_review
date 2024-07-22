@extends('layout.app')

@section('main')
<div class="container">
    <div class="row my-5">
        @include('layout.message')
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header text-white">
                    Welcome, {{ Auth::user()->name }}
                </div>
                <div class="card-body">
                    <form action="{{ route('account.updateprofile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-3">
                            @if(Auth::user()->image)
                                <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}" class="img-fluid rounded-circle" alt="{{ Auth::user()->name }}">
                            @else
                                <img src="{{ asset('images/profile-img-default.jpg') }}" class="img-fluid rounded-circle" alt="{{ Auth::user()->name }}">
                            @endif
                        </div>
                        <div class="h5 text-center">
                            <strong>{{ Auth::user()->name }}</strong>
                            <p class="h6 mt-2 text-muted">5 Reviews</p>
                        </div>
                        <!-- Additional fields for updating profile can be added here -->
                    </form>
                </div>
            </div>
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header text-white">
                    Navigation
                </div>
                <div class="card-body sidebar">
                    @include('layout.sidebar')
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card border-0 shadow">
                <div class="card-header text-white">
                    Add Book
                </div>
                <div class="card-body">
                    <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text"  value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Title" name="title" id="title" />
                            @error('title')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" value="{{ old('author') }}" class="form-control @error('author') is-invalid @enderror" placeholder="Author" name="author" id="author"/>
                            @error('author')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description" cols="30" rows="5" value="{{ old('description') }}"></textarea>
                            @error('description')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image"/>
                            @error('image')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="active">Active</option>
                                <option value="block">Block</option>
                            </select>
                            @error('status')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <button class="btn btn-primary mt-2">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
