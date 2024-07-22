  <ul class="nav flex-column">
                        @if (Auth::user()->role == 'admin')
                          <li class="nav-item">
                            <a href="{{ route('book-list.index') }}">Books</a>
                        </li>
                        <li class="nav-item">
                            <a href="reviews.html">Reviews</a>
                        </li>
                        @endif
                      
                        <li class="nav-item">
                            <a href="{{ route('account.profile') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="my-reviews.html">My Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a href="change-password.html">Change Password</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('account.logout') }}">Logout</a>
                        </li>
                    </ul>