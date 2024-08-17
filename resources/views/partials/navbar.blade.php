<nav class="navbar navbar-expand-lg py-3 navbar-dark bg-primary shadow">
    <div class="container">
        <a class="navbar-brand" href="/" style="font-family:Arial,Courier, monospace; ">My Design</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav" style="font-family: Arial ;">
            <ul class="navbar-nav">
                {{-- <li class="nav-item ">
                    <a class="nav-link {{ $active === 'home' ? 'active rounded shadow' : '' }}"
                        href="/">Home</a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link {{ $active === 'about' ? 'active  rounded shadow' : '' }}"
                        href="/about">About</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ $active === 'posts' ? 'active rounded shadow' : '' }}"
                        href="/posts">Desain</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active === 'categories' ? 'active rounded shadow' : '' }}"
                        href="/categories">Kategori</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Selamat Datang, {{ auth()->user()->name_users }}
                        </a>
                        <ul class="dropdown-menu border-primary">
                            @if (auth()->user()->is_admin)
                                <li><a class="dropdown-item" href="/dashboard"><i
                                            class="bi bi-layout-text-sidebar-reverse"></i>
                                        Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider border-primary">
                                </li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('order.index') }}"><i
                                        class="fi fi-rs-registration-paper"></i>
                                    Order</a></li>
                            <li>
                                <hr class="dropdown-divider border-primary">
                            </li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>
                                        Logout</button>
                                </form>

                        </ul>
                    </li>

                    <!-- Cart Icon with Notification -->
                    @if (!auth()->user()->is_admin)
                        <li class="nav-item">
                            <a href="/cart" class="nav-link position-relative">
                                <i class="bi bi-cart"></i>
                                @if ($cartItemCount > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartItemCount }}
                                        <span class="visually-hidden">Keranjang</span>
                                    </span>
                                @endif

                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a href="/login" class="nav-link" {{ $active === 'login' ? 'active' : '' }}><i
                                class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>

                @endauth
            </ul>


        </div>
    </div>
</nav>
