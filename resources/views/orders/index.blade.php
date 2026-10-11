@extends('layouts.app')

@section('title', 'My Orders — RIJILL X MARKET')

@section('content')

<section class="my-orders-page">

    <div class="container">

        {{-- HEADER --}}
        <div class="orders-header reveal">

            <div>

                <span class="orders-eyebrow">
                    RIJILL X MARKET / MY ORDERS
                </span>

                <h1>
                    Your
                    <span class="gradient-text">
                        orders.
                    </span>
                </h1>

                <p>
                    Pantau semua pesanan dan status pembelianmu
                    di RIJILL X MARKET.
                </p>

            </div>


            <a
                href="{{ route('products.index') }}"
                class="orders-explore"
            >
                ← Continue Exploring
            </a>

        </div>


        @if ($orders->count() > 0)

            <div class="orders-list">

                @foreach ($orders as $order)

                    <article class="order-card reveal">

                        <div class="order-card-main">


                            {{-- ORDER ID --}}
                            <div class="order-number">

                                <span class="order-label">
                                    ORDER ID
                                </span>

                                <strong>
                                    RJL-{{ str_pad(
                                        $order->id,
                                        6,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </strong>

                            </div>


                            {{-- ORDER DATE --}}
                            <div class="order-date">

                                <span class="order-label">
                                    ORDER DATE
                                </span>

                                <strong>
                                    {{ $order->created_at->format(
                                        'd M Y'
                                    ) }}
                                </strong>

                                <small>
                                    {{ $order->created_at->format(
                                        'H:i'
                                    ) }}
                                </small>

                            </div>


                            {{-- TOTAL --}}
                            <div class="order-value">

                                <span class="order-label">
                                    TOTAL
                                </span>

                                <strong>
                                    IDR
                                    {{ number_format(
                                        $order->total_price,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </strong>

                            </div>


                            {{-- ORDER STATUS --}}
                            <div class="order-status">

                                <span class="order-label">
                                    STATUS
                                </span>

                                <span
                                    class="
                                        status-badge
                                        status-{{ $order->status }}
                                    "
                                >
                                    {{ strtoupper(
                                        $order->status
                                    ) }}
                                </span>

                            </div>


                            {{-- PAYMENT STATUS --}}
                            <div class="order-payment">

                                <span class="order-label">
                                    PAYMENT
                                </span>

                                <span
                                    class="
                                        payment-badge
                                        {{ $order->payment_status === 'paid'
                                            ? 'payment-paid'
                                            : 'payment-unpaid' }}
                                    "
                                >

                                    <span class="payment-dot"></span>

                                    {{ strtoupper(
                                        $order->payment_status ?? 'unpaid'
                                    ) }}

                                </span>

                            </div>

                        </div>


                        {{-- VIEW ORDER --}}
                        <div class="order-card-action">

                            <a
                                href="{{ route(
                                    'orders.show',
                                    $order
                                ) }}"
                                class="view-order-button"
                            >

                                <span>
                                    View Order
                                </span>

                                <span class="view-order-arrow">
                                    →
                                </span>

                            </a>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            {{-- EMPTY ORDERS --}}
            <div class="orders-empty reveal">

                <div class="orders-empty-orbit">

                    <div class="orders-orbit-ring"></div>

                    <span>
                        RJL
                    </span>

                </div>


                <span class="orders-empty-code">
                    RJL / NO ORDERS
                </span>


                <h2>
                    No orders
                    <span class="gradient-text">
                        yet.
                    </span>
                </h2>


                <p>
                    Kamu belum memiliki pesanan.
                    Produk yang berhasil kamu checkout
                    akan muncul di halaman ini.
                </p>


                <a
                    href="{{ route('products.index') }}"
                    class="orders-shop-button"
                >
                    Explore Collection →
                </a>

            </div>

        @endif

    </div>

</section>


<style>

/* =========================
   MY ORDERS
========================= */

.my-orders-page {
    min-height: 100vh;
    padding: 80px 0 120px;
}


.orders-header {
    display: flex;

    justify-content: space-between;
    align-items: flex-end;

    gap: 30px;

    margin-bottom: 45px;
}


.orders-eyebrow {
    display: inline-block;

    margin-bottom: 15px;

    font-size: 11px;
    font-weight: 700;

    letter-spacing: 3px;

    color: #65e6ff;
}


.orders-header h1 {
    margin: 0;

    font-size: clamp(
        48px,
        7vw,
        92px
    );

    line-height: .95;
    letter-spacing: -4px;
}


.orders-header p {
    max-width: 570px;

    margin-top: 22px;

    color: var(--muted);

    line-height: 1.7;
}


.orders-explore {
    padding: 13px 20px;

    border: 1px solid var(--border);
    border-radius: 999px;

    color: var(--text);

    text-decoration: none;

    white-space: nowrap;

    transition: .25s ease;
}


.orders-explore:hover {
    border-color:
        rgba(101, 230, 255, .45);

    background:
        rgba(101, 230, 255, .06);
}


/* =========================
   ORDER LIST
========================= */

.orders-list {
    display: flex;

    flex-direction: column;

    gap: 16px;
}


.order-card {
    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        auto;

    align-items: center;

    gap: 25px;

    padding: 26px 28px;

    border: 1px solid var(--border);
    border-radius: 24px;

    background:
        linear-gradient(
            135deg,
            rgba(255, 255, 255, .025),
            rgba(101, 230, 255, .025)
        );

    transition:
        transform .25s ease,
        border-color .25s ease,
        background .25s ease;
}


.order-card:hover {
    transform: translateY(-2px);

    border-color:
        rgba(101, 230, 255, .28);

    background:
        linear-gradient(
            135deg,
            rgba(255, 255, 255, .04),
            rgba(101, 230, 255, .045)
        );
}


.order-card-main {
    display: grid;

    grid-template-columns:
        1.25fr
        1fr
        1fr
        .8fr
        .8fr;

    align-items: center;

    gap: 25px;
}


.order-number,
.order-date,
.order-value,
.order-status,
.order-payment {
    display: flex;

    flex-direction: column;

    gap: 7px;

    min-width: 0;
}


.order-label {
    font-size: 9px;
    font-weight: 700;

    letter-spacing: 2px;

    color: #718096;
}


.order-number strong {
    color: #6fe8ff;

    font-size: 17px;

    letter-spacing: 1px;
}


.order-date strong,
.order-value strong {
    color: var(--text);

    font-size: 15px;
}


.order-date small {
    color: var(--muted);
}


/* =========================
   ORDER STATUS
========================= */

.status-badge {
    width: fit-content;

    padding: 7px 11px;

    border-radius: 999px;

    font-size: 10px;
    font-weight: 800;

    letter-spacing: 1px;
}


.status-pending {
    color: #ffd76a;

    background:
        rgba(255, 215, 106, .09);

    border:
        1px solid rgba(255, 215, 106, .2);
}


.status-diproses {
    color: #6fe8ff;

    background:
        rgba(111, 232, 255, .08);

    border:
        1px solid rgba(111, 232, 255, .2);
}


.status-dikirim {
    color: #a9baff;

    background:
        rgba(169, 186, 255, .08);

    border:
        1px solid rgba(169, 186, 255, .2);
}


.status-selesai {
    color: #62f0b0;

    background:
        rgba(98, 240, 176, .08);

    border:
        1px solid rgba(98, 240, 176, .2);
}


.status-dibatalkan {
    color: #ff7d8f;

    background:
        rgba(255, 125, 143, .08);

    border:
        1px solid rgba(255, 125, 143, .2);
}


/* =========================
   PAYMENT STATUS
========================= */

.payment-badge {
    width: fit-content;

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 7px 11px;

    border-radius: 999px;

    font-size: 10px;
    font-weight: 800;

    letter-spacing: 1px;
}


.payment-dot {
    width: 6px;
    height: 6px;

    flex-shrink: 0;

    border-radius: 50%;
}


.payment-paid {
    color: #62f0b0;

    background:
        rgba(98, 240, 176, .08);

    border:
        1px solid rgba(98, 240, 176, .2);
}


.payment-paid .payment-dot {
    background: #62f0b0;

    box-shadow:
        0 0 8px rgba(98, 240, 176, .7);
}


.payment-unpaid {
    color: #ffb86c;

    background:
        rgba(255, 184, 108, .08);

    border:
        1px solid rgba(255, 184, 108, .2);
}


.payment-unpaid .payment-dot {
    background: #ffb86c;

    box-shadow:
        0 0 8px rgba(255, 184, 108, .7);
}


/* =========================
   VIEW BUTTON
========================= */

.view-order-button {
    min-width: 155px;

    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 20px;

    padding:
        13px
        15px
        13px
        18px;

    border:
        1px solid
        rgba(101, 230, 255, .2);

    border-radius: 14px;

    background:
        rgba(101, 230, 255, .05);

    color: var(--text);

    text-decoration: none;

    font-size: 13px;
    font-weight: 700;

    transition: .25s ease;
}


.view-order-button:hover {
    transform: translateX(3px);

    background:
        rgba(101, 230, 255, .1);

    border-color:
        rgba(101, 230, 255, .4);
}


.view-order-arrow {
    display: flex;

    align-items: center;
    justify-content: center;

    width: 31px;
    height: 31px;

    border-radius: 50%;

    background:
        rgba(101, 230, 255, .1);

    color: #6fe8ff;
}


/* =========================
   EMPTY ORDERS
========================= */

.orders-empty {
    min-height: 430px;

    display: flex;

    flex-direction: column;

    align-items: center;
    justify-content: center;

    gap: 16px;

    padding: 50px 25px;

    text-align: center;

    border: 1px solid var(--border);
    border-radius: 30px;

    background:
        radial-gradient(
            circle at 50% 40%,
            rgba(93, 124, 255, .09),
            transparent 35%
        );
}


.orders-empty-orbit {
    position: relative;

    width: 110px;
    height: 110px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-bottom: 8px;

    border:
        1px solid
        rgba(101, 230, 255, .18);

    border-radius: 50%;

    color: #6fe8ff;

    font-size: 18px;
    font-weight: 800;

    letter-spacing: 4px;
}


.orders-orbit-ring {
    position: absolute;

    width: 145px;
    height: 145px;

    border:
        1px dashed
        rgba(101, 230, 255, .14);

    border-radius: 50%;
}


.orders-empty-code {
    margin-top: 15px;

    color: #718096;

    font-size: 9px;
    font-weight: 700;

    letter-spacing: 3px;
}


.orders-empty h2 {
    margin: 0;

    font-size: clamp(
        35px,
        5vw,
        60px
    );

    letter-spacing: -2px;
}


.orders-empty p {
    max-width: 480px;

    margin: 0;

    color: var(--muted);

    line-height: 1.7;
}


.orders-shop-button {
    margin-top: 10px;

    padding: 14px 20px;

    border-radius: 14px;

    background:
        linear-gradient(
            135deg,
            #627cff,
            #6fe8ff
        );

    color: #06101a;

    text-decoration: none;

    font-weight: 800;

    transition: .25s ease;
}


.orders-shop-button:hover {
    transform: translateY(-2px);
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1150px) {

    .order-card {
        grid-template-columns: 1fr;
    }

    .order-card-main {
        grid-template-columns:
            repeat(3, 1fr);
    }

    .view-order-button {
        width: 100%;
    }

}


@media (max-width: 800px) {

    .my-orders-page {
        padding-top: 45px;
    }

    .orders-header {
        flex-direction: column;

        align-items: flex-start;
    }

    .orders-header h1 {
        letter-spacing: -2px;
    }

    .order-card-main {
        grid-template-columns:
            repeat(2, 1fr);

        gap: 22px;
    }

}


@media (max-width: 480px) {

    .order-card {
        padding: 20px;
    }

    .order-card-main {
        grid-template-columns: 1fr;
    }

    .order-number,
    .order-date,
    .order-value,
    .order-status,
    .order-payment {
        padding-bottom: 14px;

        border-bottom:
            1px solid rgba(255, 255, 255, .06);
    }

    .order-payment {
        padding-bottom: 0;

        border-bottom: 0;
    }

}

</style>

@endsection