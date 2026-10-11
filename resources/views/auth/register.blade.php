@extends('layouts.app')

@section('title', 'Register — RIJILL X MARKET')

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
                        Join what's
                        <span class="gradient-text">
                            coming next.
                        </span>
                    </h2>

                    <p>
                        Buat akun dan mulai pengalaman belanja
                        digital bersama RIJILL X MARKET.
                    </p>

                </div>

                <span class="auth-system-code">
                    RXM / REGISTRATION SYSTEM / 2026
                </span>

            </div>


            {{-- REGISTER FORM --}}
            <div class="auth-panel reveal">

                <div class="auth-panel-top">

                    <span class="auth-status">
                        <span></span>
                        REGISTRATION OPEN
                    </span>

                    <span class="auth-code">
                        02 / REGISTER
                    </span>

                </div>


                <div class="auth-heading">

                    <span>NEW IDENTITY</span>

                    <h1>
                        Create account.
                    </h1>

                    <p>
                        Daftar untuk membuat akun customer baru.
                    </p>

                </div>


                @if ($errors->any())

                    <div class="auth-errors">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                @endif


                <form
                    action="{{ route('register.process') }}"
                    method="POST"
                    class="auth-form"
                >
                    @csrf


                    <div class="auth-field">

                        <label for="name">
                            FULL NAME
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Your full name"
                            required
                            autofocus
                        >

                    </div>


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
                                placeholder="Minimum 8 characters"
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


                    <div class="auth-field">

                        <label for="password_confirmation">
                            CONFIRM PASSWORD
                        </label>

                        <div class="password-field">

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Repeat your password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-password-toggle="password_confirmation"
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
                            Create Account
                        </span>

                        <span class="auth-submit-arrow">
                            →
                        </span>
                    </button>

                </form>


                <div class="auth-switch">

                    <span>
                        Already registered?
                    </span>

                    <a href="{{ route('login') }}">
                        Sign in →
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection