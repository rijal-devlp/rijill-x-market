
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

    <style>
        /* Additional footer contact styling */
        .footer-contact-link {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            max-width: 100%;
            overflow-wrap: anywhere;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-contact-link:hover,
        .footer-contact-link:focus-visible {
            color: #55e8f5;
        }

        .footer-contact-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 18px;
            height: 18px;
        }

        .footer-contact-icon svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .footer-developer-note {
            margin-top: 12px;
            font-size: 12px;
            line-height: 1.7;
            opacity: 0.75;
        }

        .footer-contact-column {
            min-width: 0;
        }

        @media (max-width: 767px) {
            .footer-contact-column {
                width: 100%;
            }

            .footer-contact-link {
                font-size: 13px;
            }
        }
    </style>
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
                aria-controls="mobileMenu"
                aria-expanded="false"
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

            {{-- CONTACT & DEVELOPER --}}
            <div class="footer-column footer-contact-column">

                <span class="footer-title">
                    Contact & Developer
                </span>

                <a
                    href="mailto:rijalmuharam26@gmail.com"
                    class="footer-contact-link"
                    aria-label="Email Rijal Muharam"
                >
                    <span class="footer-contact-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <rect
                                x="2"
                                y="4"
                                width="20"
                                height="16"
                                rx="3"
                            ></rect>
                            <path d="m3 6 9 7 9-7"></path>
                        </svg>
                    </span>

                    <span>
                        rijalmuharam26@gmail.com
                    </span>
                </a>

                <a
                    href="https://github.com/rijal-devlp"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="footer-contact-link"
                    aria-label="GitHub Rijal Muharam"
                >
                    <span class="footer-contact-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 19c-4.3 1.4-4.3-2.5-6-3"></path>
                            <path d="M15 22v-3.9a3.4 3.4 0 0 0-.9-2.7c3-.3 6.2-1.5 6.2-6.7a5.2 5.2 0 0 0-1.4-3.6 4.8 4.8 0 0 0-.1-3.5S17.7 1.3 15 3a13.7 13.7 0 0 0-6 0C6.3 1.3 5.2 1.6 5.2 1.6a4.8 4.8 0 0 0-.1 3.5 5.2 5.2 0 0 0-1.4 3.6c0 5.2 3.2 6.4 6.2 6.7A3.4 3.4 0 0 0 9 18.1V22"></path>
                        </svg>
                    </span>

                    <span>
                        github.com/rijal-devlp
                    </span>
                </a>

                <p class="footer-developer-note">
                    Developed by Rijal Muharam.
                    <br>
                    Full-Stack Web Development Portfolio.
                </p>

            </div>

        </div>

        {{-- FOOTER BOTTOM --}}
        <div class="container footer-bottom">

            <span>
                © {{ date('Y') }} RIJILL X MARKET
            </span>

            <span>
                Designed & Developed by Rijal Muharam
            </span>

        </div>

    </footer>

</body>

</html>
