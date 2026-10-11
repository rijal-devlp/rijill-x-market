<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="RIJILL X MARKET - Future Commerce Experience"
    >

    <title>
        @yield('title', 'RIJILL X MARKET')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

    {{-- BACKGROUND DECORATION --}}
    <div class="ambient ambient-one"></div>
    <div class="ambient ambient-two"></div>


    {{-- =========================
         NAVBAR
    ========================== --}}

    <header class="site-header">

        <nav class="navbar container">

            {{-- LOGO --}}
            <a
                href="
                    @auth
                        @if (Auth::user()->role === 'admin')
                            {{ route('admin.dashboard') }}
                        @else
                            {{ route('products.index') }}
                        @endif
                    @else
                        {{ route('products.index') }}
                    @endauth
                "
                class="brand"
            >
                RIJILL<span> X</span> MARKET
            </a>


            {{-- =========================
                 DESKTOP NAVIGATION
            ========================== --}}

            <div class="nav-links">

                {{-- GUEST --}}
                @guest

                    <a href="{{ route('products.index') }}">
                        Explore
                    </a>

                    <a href="{{ route('cart.index') }}">
                        Cart
                    </a>

                @endguest


                {{-- LOGGED IN --}}
                @auth

                    {{-- CUSTOMER --}}
                    @if (Auth::user()->role !== 'admin')

                        <a href="{{ route('products.index') }}">
                            Explore
                        </a>

                        <a href="{{ route('cart.index') }}">
                            Cart
                        </a>

                        <a href="{{ route('orders.my') }}">
                            My Orders
                        </a>

                    @endif


                    {{-- ADMIN --}}
                    @if (Auth::user()->role === 'admin')

                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>

                        <a href="{{ route('admin.products.index') }}">
                            Products
                        </a>

                        <a href="{{ route('admin.orders.index') }}">
                            Orders
                        </a>

                        <a href="{{ route('admin.products.trash') }}">
                            Trash
                        </a>

                    @endif

                @endauth

            </div>


            {{-- =========================
                 ACCOUNT AREA
            ========================== --}}

            <div class="nav-account">

                @guest

                    <a
                        href="{{ route('login') }}"
                        class="nav-login"
                    >
                        Login
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="btn btn-primary btn-small"
                    >
                        Join RIJILL X MARKET
                    </a>

                @else

                    <div class="user-chip">

                        <span class="user-dot"></span>

                        <span>
                            {{ Auth::user()->name }}
                        </span>

                    </div>


                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="logout-button"
                        >
                            Logout
                        </button>

                    </form>

                @endguest

            </div>


            {{-- MOBILE BUTTON --}}
            <button
                class="menu-button"
                id="menuButton"
                type="button"
                aria-label="Buka menu"
            >
                <span></span>
                <span></span>
            </button>

        </nav>


        {{-- =========================
             MOBILE NAVIGATION
        ========================== --}}

        <div
            class="mobile-menu"
            id="mobileMenu"
        >

            {{-- GUEST --}}
            @guest

                <a href="{{ route('products.index') }}">
                    Explore
                </a>

                <a href="{{ route('cart.index') }}">
                    Cart
                </a>

                <a href="{{ route('login') }}">
                    Login
                </a>

                <a href="{{ route('register') }}">
                    Register
                </a>

            @endguest


            {{-- LOGGED IN --}}
            @auth

                {{-- CUSTOMER --}}
                @if (Auth::user()->role !== 'admin')

                    <a href="{{ route('products.index') }}">
                        Explore
                    </a>

                    <a href="{{ route('cart.index') }}">
                        Cart
                    </a>

                    <a href="{{ route('orders.my') }}">
                        My Orders
                    </a>

                @endif


                {{-- ADMIN --}}
                @if (Auth::user()->role === 'admin')

                    <a href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.products.index') }}">
                        Products
                    </a>

                    <a href="{{ route('admin.orders.index') }}">
                        Orders
                    </a>

                    <a href="{{ route('admin.products.trash') }}">
                        Trash
                    </a>

                @endif


                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf

                    <button type="submit">
                        Logout
                    </button>

                </form>

            @endauth

        </div>

    </header>


    {{-- =========================
         PAGE CONTENT
    ========================== --}}

    <main class="main-content">

        {{-- SUCCESS --}}
        @if (session('success'))

            <div class="container">

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- ERROR --}}
        @if (session('error'))

            <div class="container">

                <div class="alert alert-error">
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- VALIDATION --}}
        @if ($errors->any())

            <div class="container">

                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>

            </div>

        @endif


        @yield('content')

    </main>


    {{-- =========================
         FOOTER
    ========================== --}}

    <footer class="footer">

        <div class="container footer-grid">

            {{-- BRAND --}}
            <div>

                <a
                    href="{{ route('products.index') }}"
                    class="brand footer-brand"
                >
                    RIJILL<span> X</span> MARKET
                </a>

                <p class="footer-description">
                    A new dimension of digital commerce.
                    Designed for what's next.
                </p>

            </div>


            {{-- NAVIGATION --}}
            <div class="footer-column">

                <span class="footer-title">
                    Navigation
                </span>


                @guest

                    <a href="{{ route('products.index') }}">
                        Products
                    </a>

                    <a href="{{ route('cart.index') }}">
                        Cart
                    </a>

                @endguest


                @auth

                    {{-- CUSTOMER --}}
                    @if (Auth::user()->role !== 'admin')

                        <a href="{{ route('products.index') }}">
                            Products
                        </a>

                        <a href="{{ route('cart.index') }}">
                            Cart
                        </a>

                        <a href="{{ route('orders.my') }}">
                            My Orders
                        </a>

                    @endif


                    {{-- ADMIN --}}
                    @if (Auth::user()->role === 'admin')

                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>

                        <a href="{{ route('admin.products.index') }}">
                            Products
                        </a>

                        <a href="{{ route('admin.orders.index') }}">
                            Orders
                        </a>

                        <a href="{{ route('admin.products.trash') }}">
                            Trash
                        </a>

                    @endif

                @endauth

            </div>


            {{-- ACCOUNT --}}
            <div class="footer-column">

                <span class="footer-title">
                    Account
                </span>


                @guest

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                    <a href="{{ route('register') }}">
                        Register
                    </a>

                @else

                    <span>
                        {{ Auth::user()->name }}
                    </span>


                    @if (Auth::user()->role === 'admin')

                        <span>
                            Administrator
                        </span>

                    @else

                        <a href="{{ route('orders.my') }}">
                            Order History
                        </a>

                    @endif

                @endguest

            </div>

        </div>


        {{-- FOOTER BOTTOM --}}
        <div class="container footer-bottom">

            <span>
                © {{ date('Y') }} RIJILL X MARKET
            </span>

            <span>
                Future Commerce System
            </span>

        </div>

    </footer>

</body>
</html>