@extends('layouts.app')

@section('title', 'Order Detail — RIJILL X MARKET')

@section('content')

<section class="customer-order-page">
    <div class="container">

        {{-- BACK --}}
        <a
            href="{{ route('orders.my') }}"
            class="order-back"
        >
            ← Back to My Orders
        </a>


        {{-- HEADER --}}
        <div class="customer-order-header reveal">

            <div>
                <span class="order-eyebrow">
                    RIJILL X MARKET / ORDER DETAIL
                </span>

                <h1>
                    Order
                    <span class="gradient-text">
                        details.
                    </span>
                </h1>

                <p>
                    Informasi lengkap mengenai pesananmu
                    di RIJILL X MARKET.
                </p>
            </div>


            <div class="order-header-id">
                <span>
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

        </div>


        {{-- STATUS --}}
        <div class="customer-order-status reveal">

            <div>
                <span class="status-label">
                    CURRENT STATUS
                </span>

                <span
                    class="
                        customer-status-badge
                        customer-status-{{ $order->status }}
                    "
                >
                    {{ strtoupper($order->status) }}
                </span>
            </div>


            <div class="status-date">
                <span>
                    ORDER DATE
                </span>

                <strong>
                    {{ $order->created_at->format(
                        'd M Y · H:i'
                    ) }}
                </strong>
            </div>

        </div>


        <div class="customer-order-layout">


            {{-- =====================================
                ORDER ITEMS
            ====================================== --}}

            <div class="customer-order-items">

                <div class="order-section-heading">

                    <span>
                        ORDER CONTENT
                    </span>

                    <small>
                        {{ $order->items->sum('quantity') }}
                        ITEM
                    </small>

                </div>


                @foreach ($order->items as $item)

                    <article class="customer-order-item reveal">


                        {{-- PRODUCT IMAGE --}}
                        <div class="order-product-image">

                            @if ($item->product_image)

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $item->product_image
                                    ) }}"
                                    alt="{{ $item->product_name }}"
                                    loading="lazy"
                                >

                            @else

                                {{-- ORDER LAMA --}}
                                <div class="order-product-image-placeholder">

                                    <span>
                                        RXM
                                    </span>

                                    <small>
                                        NO SNAPSHOT
                                    </small>

                                </div>

                            @endif

                        </div>


                        {{-- PRODUCT CODE --}}
                        <div class="order-product-code">

                            @if ($item->product_id)

                                RJL /

                                {{ str_pad(
                                    $item->product_id,
                                    3,
                                    '0',
                                    STR_PAD_LEFT
                                ) }}

                            @else

                                RJL / ARCHIVED

                            @endif

                        </div>


                        {{-- PRODUCT --}}
                        <div class="order-product-info">

                            <span>
                                PRODUCT
                            </span>

                            <h2>
                                {{ $item->product_name }}
                            </h2>

                        </div>


                        {{-- PRICE --}}
                        <div class="order-product-price">

                            <span>
                                UNIT PRICE
                            </span>

                            <strong>
                                IDR
                                {{ number_format(
                                    $item->price,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>

                        </div>


                        {{-- QUANTITY --}}
                        <div class="order-product-qty">

                            <span>
                                QTY
                            </span>

                            <strong>
                                {{ $item->quantity }}
                            </strong>

                        </div>


                        {{-- SUBTOTAL --}}
                        <div class="order-product-subtotal">

                            <span>
                                SUBTOTAL
                            </span>

                            <strong>
                                IDR
                                {{ number_format(
                                    $item->subtotal,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- =====================================
                ORDER SUMMARY
            ====================================== --}}

            <aside class="customer-order-summary reveal">

                <span class="summary-eyebrow">
                    SHIPPING INFORMATION
                </span>

                <h2>
                    Order
                    <span class="gradient-text">
                        summary.
                    </span>
                </h2>


                <div class="customer-summary-divider"></div>


                {{-- CUSTOMER --}}
                <div class="customer-info-row">

                    <span>
                        Customer
                    </span>

                    <strong>
                        {{ $order->customer_name }}
                    </strong>

                </div>


                {{-- EMAIL --}}
                <div class="customer-info-row">

                    <span>
                        Email
                    </span>

                    <strong>
                        {{ $order->email }}
                    </strong>

                </div>


                {{-- PHONE --}}
                <div class="customer-info-row">

                    <span>
                        Phone
                    </span>

                    <strong>
                        {{ $order->phone }}
                    </strong>

                </div>


                {{-- ADDRESS --}}
                <div class="customer-address">

                    <span>
                        SHIPPING ADDRESS
                    </span>

                    <p>
                        {{ $order->address }}
                    </p>

                </div>


                {{-- =====================================
                    PAYMENT INFORMATION
                ====================================== --}}

                <div class="customer-summary-divider"></div>


                <div class="customer-payment-section">

                    <span class="customer-payment-eyebrow">
                        PAYMENT INFORMATION
                    </span>


                    {{-- PAYMENT METHOD --}}
                    <div class="customer-info-row customer-payment-row">

                        <span>
                            Payment Method
                        </span>

                        <strong>

                            @switch($order->payment_method)

                                @case('qris')
                                    QRIS
                                    @break

                                @case('bank_transfer')
                                    BANK TRANSFER
                                    @break

                                @case('ewallet')
                                    E-WALLET
                                    @break

                                @case('cod')
                                    CASH ON DELIVERY
                                    @break

                                @default
                                    NOT RECORDED

                            @endswitch

                        </strong>

                    </div>


                    {{-- PAYMENT STATUS --}}
                    <div class="customer-info-row customer-payment-row">

                        <span>
                            Payment Status
                        </span>

                        <strong
                            class="
                                customer-payment-status
                                {{ $order->payment_status === 'paid'
                                    ? 'customer-payment-paid'
                                    : 'customer-payment-unpaid' }}
                            "
                        >

                            <span class="payment-status-dot"></span>

                            {{ strtoupper(
                                $order->payment_status ?? 'unpaid'
                            ) }}

                        </strong>

                    </div>

                </div>


                <div class="customer-summary-divider"></div>


                {{-- TOTAL --}}
                <div class="customer-order-total">

                    <div>

                        <span>
                            TOTAL
                        </span>

                        <small>
                            Final order value
                        </small>

                    </div>


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

            </aside>

        </div>

    </div>
</section>


<style>

/* =====================================================
   CUSTOMER ORDER DETAIL
===================================================== */

.customer-order-page {
    min-height: 100vh;
    padding: 65px 0 120px;
}


/* =====================================================
   BACK BUTTON
===================================================== */

.order-back {
    display: inline-flex;

    margin-bottom: 40px;

    color: var(--muted);
    text-decoration: none;

    font-size: 13px;
    font-weight: 600;

    transition: .2s ease;
}

.order-back:hover {
    color: #6fe8ff;
}


/* =====================================================
   HEADER
===================================================== */

.customer-order-header {
    display: flex;

    justify-content: space-between;
    align-items: flex-end;

    gap: 40px;

    margin-bottom: 40px;
}

.order-eyebrow {
    display: inline-block;

    margin-bottom: 14px;

    color: #6fe8ff;

    font-size: 10px;
    font-weight: 800;
    letter-spacing: 3px;
}

.customer-order-header h1 {
    margin: 0;

    font-size: clamp(
        48px,
        7vw,
        88px
    );

    line-height: .95;
    letter-spacing: -4px;
}

.customer-order-header p {
    max-width: 520px;

    margin-top: 20px;

    color: var(--muted);

    line-height: 1.7;
}


/* ORDER ID */

.order-header-id {
    min-width: 240px;

    display: flex;
    flex-direction: column;

    gap: 8px;

    padding: 20px 24px;

    border: 1px solid var(--border);
    border-radius: 18px;

    background:
        rgba(255, 255, 255, .025);
}

.order-header-id span {
    color: #718096;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 2px;
}

.order-header-id strong {
    color: #6fe8ff;

    font-size: 20px;

    letter-spacing: 1px;
}


/* =====================================================
   STATUS
===================================================== */

.customer-order-status {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 25px;

    margin-bottom: 25px;

    padding: 20px 24px;

    border: 1px solid var(--border);
    border-radius: 20px;

    background:
        linear-gradient(
            135deg,
            rgba(255, 255, 255, .025),
            rgba(101, 230, 255, .025)
        );
}

.customer-order-status > div {
    display: flex;

    align-items: center;

    gap: 14px;
}

.status-label,
.status-date span {
    color: #718096;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 2px;
}

.status-date strong {
    font-size: 13px;
}


/* =====================================================
   STATUS BADGES
===================================================== */

.customer-status-badge {
    display: inline-flex;

    padding: 7px 12px;

    border-radius: 999px;

    font-size: 10px;
    font-weight: 800;

    letter-spacing: 1px;
}

.customer-status-pending {
    color: #ffd76a;

    background:
        rgba(255, 215, 106, .08);

    border:
        1px solid rgba(255, 215, 106, .2);
}

.customer-status-diproses {
    color: #6fe8ff;

    background:
        rgba(111, 232, 255, .08);

    border:
        1px solid rgba(111, 232, 255, .2);
}

.customer-status-dikirim {
    color: #a9baff;

    background:
        rgba(169, 186, 255, .08);

    border:
        1px solid rgba(169, 186, 255, .2);
}

.customer-status-selesai {
    color: #62f0b0;

    background:
        rgba(98, 240, 176, .08);

    border:
        1px solid rgba(98, 240, 176, .2);
}

.customer-status-dibatalkan {
    color: #ff7d8f;

    background:
        rgba(255, 125, 143, .08);

    border:
        1px solid rgba(255, 125, 143, .2);
}


/* =====================================================
   MAIN LAYOUT
===================================================== */

.customer-order-layout {
    display: grid;

    grid-template-columns:
        minmax(0, 1.6fr)
        minmax(300px, .7fr);

    gap: 25px;

    align-items: start;
}


/* =====================================================
   ORDER ITEMS
===================================================== */

.customer-order-items {
    display: flex;

    flex-direction: column;

    gap: 12px;
}

.order-section-heading {
    display: flex;

    justify-content: space-between;

    padding: 0 5px 12px;

    color: #718096;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 2px;
}


/* =====================================================
   PRODUCT CARD
===================================================== */

.customer-order-item {
    display: grid;

    grid-template-columns:
        96px
        80px
        minmax(150px, 1fr)
        125px
        50px
        135px;

    align-items: center;

    gap: 16px;

    padding: 18px;

    border: 1px solid var(--border);
    border-radius: 20px;

    background:
        rgba(255, 255, 255, .02);

    transition:
        border-color .2s ease,
        transform .2s ease,
        background .2s ease;
}

.customer-order-item:hover {
    border-color:
        rgba(111, 232, 255, .18);

    background:
        rgba(111, 232, 255, .025);
}


/* =====================================================
   PRODUCT IMAGE
===================================================== */

.order-product-image {
    width: 96px;
    height: 96px;

    overflow: hidden;

    border:
        1px solid var(--border);

    border-radius: 16px;

    background:
        rgba(255, 255, 255, .025);
}

.order-product-image img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;
}


/* OLD ORDER PLACEHOLDER */

.order-product-image-placeholder {
    width: 100%;
    height: 100%;

    display: flex;

    flex-direction: column;

    align-items: center;
    justify-content: center;

    gap: 4px;

    background:
        radial-gradient(
            circle at 50% 20%,
            rgba(111, 232, 255, .12),
            transparent 60%
        ),
        rgba(255, 255, 255, .02);
}

.order-product-image-placeholder span {
    color: #6fe8ff;

    font-size: 13px;
    font-weight: 800;

    letter-spacing: 2px;
}

.order-product-image-placeholder small {
    color: #718096;

    font-size: 7px;
    font-weight: 800;

    letter-spacing: 1px;
}


/* =====================================================
   PRODUCT CODE
===================================================== */

.order-product-code {
    color: #718096;

    font-size: 10px;
    font-weight: 700;

    letter-spacing: 1px;

    line-height: 1.5;
}


/* =====================================================
   PRODUCT INFO
===================================================== */

.order-product-info span,
.order-product-price span,
.order-product-qty span,
.order-product-subtotal span {
    display: block;

    margin-bottom: 7px;

    color: #718096;

    font-size: 8px;
    font-weight: 800;

    letter-spacing: 1.5px;
}

.order-product-info h2 {
    margin: 0;

    font-size: 16px;

    line-height: 1.4;

    word-break: break-word;
}

.order-product-price strong,
.order-product-qty strong,
.order-product-subtotal strong {
    font-size: 13px;
}

.order-product-subtotal {
    text-align: right;
}


/* =====================================================
   SUMMARY
===================================================== */

.customer-order-summary {
    padding: 28px;

    border: 1px solid var(--border);
    border-radius: 25px;

    background:
        radial-gradient(
            circle at 100% 0%,
            rgba(101, 230, 255, .08),
            transparent 35%
        ),
        rgba(255, 255, 255, .02);
}

.summary-eyebrow {
    color: #62f0b0;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 2px;
}

.customer-order-summary h2 {
    margin: 10px 0 0;

    font-size: 30px;

    letter-spacing: -1px;
}

.customer-summary-divider {
    height: 1px;

    margin: 24px 0;

    background: var(--border);
}


/* =====================================================
   CUSTOMER INFO
===================================================== */

.customer-info-row {
    display: flex;

    justify-content: space-between;
    align-items: center;

    gap: 20px;

    margin-bottom: 17px;
}

.customer-info-row span {
    color: var(--muted);

    font-size: 12px;
}

.customer-info-row strong {
    max-width: 190px;

    text-align: right;

    font-size: 12px;

    word-break: break-word;
}


/* ADDRESS */

.customer-address {
    margin-top: 25px;
}

.customer-address span {
    color: #718096;

    font-size: 8px;
    font-weight: 800;

    letter-spacing: 2px;
}

.customer-address p {
    margin: 9px 0 0;

    color: var(--text);

    font-size: 13px;

    line-height: 1.7;

    word-break: break-word;
}


/* =====================================================
   PAYMENT INFORMATION
===================================================== */

.customer-payment-section {
    display: flex;

    flex-direction: column;

    gap: 3px;
}

.customer-payment-eyebrow {
    display: block;

    margin-bottom: 18px;

    color: #6fe8ff;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 2px;
}

.customer-payment-row {
    min-height: 36px;
}


/* PAYMENT STATUS */

.customer-payment-status {
    width: fit-content;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    padding: 7px 10px;

    border-radius: 999px;

    font-size: 9px !important;
    font-weight: 800;

    letter-spacing: 1px;
}

.customer-payment-status .payment-status-dot {
    width: 6px;
    height: 6px;

    flex-shrink: 0;

    border-radius: 50%;
}

.customer-payment-paid {
    color: #62f0b0;

    border:
        1px solid rgba(98, 240, 176, .22);

    background:
        rgba(98, 240, 176, .08);
}

.customer-payment-paid .payment-status-dot {
    background: #62f0b0;

    box-shadow:
        0 0 9px rgba(98, 240, 176, .7);
}

.customer-payment-unpaid {
    color: #ffb86c;

    border:
        1px solid rgba(255, 184, 108, .22);

    background:
        rgba(255, 184, 108, .08);
}

.customer-payment-unpaid .payment-status-dot {
    background: #ffb86c;

    box-shadow:
        0 0 9px rgba(255, 184, 108, .7);
}


/* =====================================================
   TOTAL
===================================================== */

.customer-order-total {
    display: flex;

    align-items: flex-end;
    justify-content: space-between;

    gap: 20px;
}

.customer-order-total > div {
    display: flex;

    flex-direction: column;

    gap: 5px;
}

.customer-order-total span {
    color: #718096;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 2px;
}

.customer-order-total small {
    color: var(--muted);

    font-size: 10px;
}

.customer-order-total strong {
    color: #6fe8ff;

    font-size: 20px;

    text-align: right;
}


/* =====================================================
   RESPONSIVE — LAPTOP / TABLET
===================================================== */

@media (max-width: 1200px) {

    .customer-order-layout {
        grid-template-columns: 1fr;
    }

    .customer-order-summary {
        max-width: none;
    }

}


/* =====================================================
   RESPONSIVE — TABLET
===================================================== */

@media (max-width: 900px) {

    .customer-order-item {
        grid-template-columns:
            90px
            70px
            minmax(140px, 1fr)
            110px
            45px
            120px;

        gap: 12px;
    }

    .order-product-image {
        width: 90px;
        height: 90px;
    }

    .order-product-info h2 {
        font-size: 14px;
    }

    .order-product-price strong,
    .order-product-qty strong,
    .order-product-subtotal strong {
        font-size: 12px;
    }

}


/* =====================================================
   RESPONSIVE — MOBILE
===================================================== */

@media (max-width: 760px) {

    .customer-order-page {
        padding-top: 40px;
    }

    .customer-order-header {
        flex-direction: column;

        align-items: flex-start;
    }

    .customer-order-header h1 {
        letter-spacing: -2px;
    }

    .order-header-id {
        width: 100%;
    }

    .customer-order-status {
        flex-direction: column;

        align-items: flex-start;
    }

    .customer-order-status > div {
        width: 100%;

        justify-content: space-between;
    }


    /*
     * Product card menjadi 2 kolom
     * agar tetap nyaman di HP.
     */

    .customer-order-item {
        grid-template-columns:
            110px
            minmax(0, 1fr);

        gap: 16px;

        padding: 16px;
    }

    .order-product-image {
        width: 110px;
        height: 110px;

        grid-row:
            span 2;
    }

    .order-product-code {
        align-self: end;
    }

    .order-product-info {
        align-self: start;
    }

    .order-product-price,
    .order-product-qty,
    .order-product-subtotal {
        padding-top: 12px;

        border-top:
            1px solid var(--border);
    }

    .order-product-subtotal {
        text-align: left;
    }

    .customer-order-summary {
        padding: 22px;
    }

}


/* =====================================================
   RESPONSIVE — SMALL MOBILE
===================================================== */

@media (max-width: 480px) {

    .customer-order-header h1 {
        font-size: 46px;
    }

    .customer-order-item {
        grid-template-columns: 1fr;
    }

    .order-product-image {
        width: 100%;
        height: 220px;

        grid-row: auto;
    }

    .order-product-code {
        margin-top: 3px;
    }

    .customer-info-row,
    .customer-order-total {
        align-items: flex-start;

        flex-direction: column;
    }

    .customer-info-row strong {
        max-width: none;

        text-align: left;
    }

    .customer-payment-status {
        align-self: flex-start;
    }

    .customer-order-total strong {
        text-align: left;
    }

}

</style>

@endsection