@extends('layouts.app')

@section('title', 'Checkout — RIJILL X MARKET')

@section('content')

<section class="checkout-page">

    <div class="container">

        {{-- HEADER --}}
        <div class="checkout-header reveal">

            <div>
                <span class="eyebrow">
                    RIJILL X MARKET / SECURE CHECKOUT
                </span>

                <h1>
                    Complete your
                    <span class="gradient-text">order.</span>
                </h1>

                <p>
                    Selesaikan informasi pengiriman untuk
                    melanjutkan pesananmu.
                </p>
            </div>

            <div class="checkout-step">
                <span>CHECKOUT</span>
                <strong>01 / 02</strong>
            </div>

        </div>


        <div class="checkout-layout">

            {{-- =====================================================
                 CUSTOMER INFORMATION
            ====================================================== --}}

            <div class="checkout-form-panel reveal">

                <div class="checkout-panel-heading">

                    <div class="checkout-panel-number">
                        01
                    </div>

                    <div>
                        <span>CUSTOMER INFORMATION</span>

                        <h2>
                            Delivery details
                        </h2>
                    </div>

                </div>


                @if ($errors->any())

                    <div class="checkout-errors">

                        <strong>
                            Please check your information.
                        </strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                @endif


                <form
                    action="{{ route('checkout.store') }}"
                    method="POST"
                    class="checkout-form"
                >

                    @csrf


                    {{-- NAME --}}

                    <div class="checkout-field">

                        <label for="customer_name">
                            FULL NAME
                        </label>

                        <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            placeholder="Your full name"
                            required
                        >

                    </div>


                    {{-- EMAIL + PHONE --}}

                    <div class="checkout-field-grid">

                        <div class="checkout-field">

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


                        <div class="checkout-field">

                            <label for="phone">
                                PHONE NUMBER
                            </label>

                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="08xxxxxxxxxx"
                                required
                            >

                        </div>

                    </div>


                    {{-- ADDRESS --}}

                    <div class="checkout-field">

                        <label for="address">
                            DELIVERY ADDRESS
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="5"
                            placeholder="Masukkan alamat lengkap pengiriman..."
                            required
                        >{{ old('address') }}</textarea>

                    </div>
                    {{-- PAYMENT METHOD --}}

<div class="checkout-field">

    <label>
        PAYMENT METHOD
    </label>

    <div class="payment-method-grid">

        <label class="payment-method-card">

            <input
                type="radio"
                name="payment_method"
                value="qris"
                {{ old('payment_method') === 'qris' ? 'checked' : '' }}
                required
            >

            <span class="payment-method-content">

                <span class="payment-method-icon">
                    QR
                </span>

                <span>
                    <strong>QRIS</strong>
                    <small>Scan QR untuk pembayaran</small>
                </span>

            </span>

        </label>


        <label class="payment-method-card">

            <input
                type="radio"
                name="payment_method"
                value="bank_transfer"
                {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}
                required
            >

            <span class="payment-method-content">

                <span class="payment-method-icon">
                    BK
                </span>

                <span>
                    <strong>Bank Transfer</strong>
                    <small>Transfer melalui rekening bank</small>
                </span>

            </span>

        </label>


        <label class="payment-method-card">

            <input
                type="radio"
                name="payment_method"
                value="ewallet"
                {{ old('payment_method') === 'ewallet' ? 'checked' : '' }}
                required
            >

            <span class="payment-method-content">

                <span class="payment-method-icon">
                    EW
                </span>

                <span>
                    <strong>E-Wallet</strong>
                    <small>Pembayaran melalui dompet digital</small>
                </span>

            </span>

        </label>


        <label class="payment-method-card">

            <input
                type="radio"
                name="payment_method"
                value="cod"
                {{ old('payment_method') === 'cod' ? 'checked' : '' }}
                required
            >

            <span class="payment-method-content">

                <span class="payment-method-icon">
                    COD
                </span>

                <span>
                    <strong>Cash on Delivery</strong>
                    <small>Bayar saat pesanan diterima</small>
                </span>

            </span>

        </label>

    </div>

</div>


                    <div class="checkout-form-note">

                        <span class="checkout-note-icon">
                            ◆
                        </span>

                        <p>
                            Pastikan nama, nomor telepon, dan
                            alamat pengiriman sudah benar sebelum
                            membuat pesanan.
                        </p>

                    </div>


                    <button
                        type="submit"
                        class="place-order-button"
                    >

                        <span>
                            Place Order
                        </span>

                        <span class="place-order-arrow">
                            →
                        </span>

                    </button>

                </form>

            </div>


            {{-- =====================================================
                 ORDER SUMMARY
            ====================================================== --}}

            <aside class="checkout-summary reveal">

                <div class="checkout-summary-top">

                    <div>
                        <span class="summary-kicker">
                            ORDER / LIVE
                        </span>

                        <h2>
                            Your selection.
                        </h2>
                    </div>

                    <span class="checkout-live-dot"></span>

                </div>


                <div class="checkout-summary-items">

                    @foreach ($cart as $id => $item)

                        <div class="checkout-summary-item">

                            <div class="checkout-summary-image">

                                @if ($item['image'])

                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            $item['image']
                                        ) }}"
                                        alt="{{ $item['name'] }}"
                                    >

                                @else

                                    <span>RJL</span>

                                @endif

                            </div>


                            <div class="checkout-summary-info">

                                <span>
                                    RJL /
                                    {{ str_pad(
                                        $id,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </span>

                                <h3>
                                    {{ $item['name'] }}
                                </h3>

                                <small>
                                    QTY {{ $item['quantity'] }}
                                </small>

                            </div>


                            <strong class="checkout-summary-price">
                                IDR
                                {{ number_format(
                                    $item['price'] *
                                    $item['quantity'],
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>

                        </div>

                    @endforeach

                </div>


                <div class="checkout-summary-line"></div>


                <div class="checkout-price-row">

                    <span>
                        Subtotal
                    </span>

                    <strong>
                        IDR
                        {{ number_format(
                            $total,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                <div class="checkout-price-row">

                    <span>
                        Delivery
                    </span>

                    <strong class="checkout-muted-value">
                        Calculated later
                    </strong>

                </div>


                <div class="checkout-summary-line"></div>


                <div class="checkout-grand-total">

                    <div>
                        <span>TOTAL</span>

                        <small>
                            Current order value
                        </small>
                    </div>

                    <strong>
                        IDR
                        {{ number_format(
                            $total,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                <div class="checkout-secure">

                    <div class="secure-symbol">
                        ◇
                    </div>

                    <div>
                        <strong>
                            SECURE CHECKOUT
                        </strong>

                        <p>
                            Order information is processed
                            securely by RIJILL X MARKET.
                        </p>
                    </div>

                </div>


                <a
                    href="{{ route('cart.index') }}"
                    class="checkout-back"
                >
                    ← Return to cart
                </a>

            </aside>

        </div>

    </div>

</section>

@endsection