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
                    <div class="card-header  text-white">
                        Profile
                    </div>
                    <div class="card-body">
                        <form action="{{ route('account.updateprofile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" value="{{ old('name', $user->name) }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                    name="name" id="name" />
                                @error('name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" value="{{ old('email', $user->email) }}"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                    name="email" id="email" />
                                @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label @error('image') is-invalid @enderror">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                                @if (Auth::user()->image)
                                    <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}" class="img-fluid mt-4"
                                        alt="{{ Auth::user()->name }}">
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
