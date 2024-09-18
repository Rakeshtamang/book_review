<div class="card border-0 shadow-lg">
    <div class="card-header text-white">
        Welcome, {{ Auth::user()->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('account.updateprofile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text-center mb-3">
                @if (Auth::user()->image)
                    <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}" class="img-fluid rounded-circle"
                        alt="{{ Auth::user()->name }}">
                @else
                    <img src="{{ asset('images/profile-img-default.jpg') }}" class="img-fluid rounded-circle"
                        alt="{{ Auth::user()->name }}">
                @endif
            </div>
            <div class="h5 text-center">
                <strong>{{ Auth::user()->name }}</strong>
                <p class="h6 mt-2 text-muted">5 Reviews</p>
            </div>
        </form>
    </div>
</div>
<div class="card border-0 shadow-lg mt-3">
    <div class="card-header text-white">
        Navigation
    </div>
    <div class="card-body sidebar">
        <ul class="nav flex-column">
            @if (Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('book-list.index') }}">Books</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('account.adminreviews') }}">Reviews</a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('account.profile') }}">Profile</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('myreviews.myReviews') }}">My Reviews</a>
            </li>
            <li class="nav-item">
                <a href="change-password.html">Change Password</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('account.logout') }}">Logout</a>
            </li>
        </ul>
    </div>
</div>
