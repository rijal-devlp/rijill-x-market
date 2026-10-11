@extends('layouts.app')

@section('title', 'Login — RIJILL X MARKET')

@section('content')

<section class="auth-page">

    <div class="container">

        <div class="auth-shell">

            {{-- LEFT VISUAL --}}
            <div class="auth-visual reveal">

                <div class="auth-visual-grid"></div>

                <div class="auth-orbit">
                    <div class="auth-ring auth-ring-one"></div>
                    <div class="auth-ring auth-ring-two"></div>

                    <div class="auth-core">
                        RXM
                    </div>
                </div>

                <div class="auth-visual-content">

                    <span class="eyebrow">
                        RIJILL X MARKET
                    </span>

                    <h2>
                        Enter the
                        <span class="gradient-text">
                            next space.
                        </span>
                    </h2>

                    <p>
                        Access your account and continue your
                        experience inside RIJILL X MARKET.
                    </p>

                </div>

                <span class="auth-system-code">
                    RXM / ACCESS SYSTEM / 2026
                </span>

            </div>


            {{-- LOGIN FORM --}}
            <div class="auth-panel reveal">

                <div class="auth-panel-top">

                    <span class="auth-status">
                        <span></span>
                        SYSTEM ONLINE
                    </span>

                    <span class="auth-code">
                        01 / LOGIN
                    </span>

                </div>


                <div class="auth-heading">

                    <span>WELCOME BACK</span>

                    <h1>
                        Sign in.
                    </h1>

                    <p>
                        Masuk menggunakan akun RIJILL X MARKET.
                    </p>

                </div>


                @if ($errors->any())

                    <div class="auth-errors">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                @endif


                @if (session('success'))

                    <div class="auth-success">
                        {{ session('success') }}
                    </div>

                @endif


                <form
                    action="{{ route('login.process') }}"
                    method="POST"
                    class="auth-form"
                >
                    @csrf


                    <div class="auth-field">

                        <label for="email">
                            EMAIL ADDRESS
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="name@example.com"
                            required
                            autofocus
                        >

                    </div>


                    <div class="auth-field">

                        <label for="password">
                            PASSWORD
                        </label>

                        <div class="password-field">

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-password-toggle="password"
                            >
                                SHOW
                            </button>

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="auth-submit"
                    >
                        <span>
                            Enter RIJILL X MARKET
                        </span>

                        <span class="auth-submit-arrow">
                            →
                        </span>
                    </button>

                </form>


                <div class="auth-switch">

                    <span>
                        New to RIJILL X MARKET?
                    </span>

                    <a href="{{ route('register') }}">
                        Create account →
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection