@extends('layouts.app')

@section('title', 'Order Detail — RIJILL X MARKET')

@section('content')

<section class="order-detail-page">

    <div class="container">

        {{-- HEADER --}}
        <div class="order-detail-header reveal">

            <div>

                <span class="eyebrow">
                    RIJILL X MARKET / ADMIN / ORDER DETAIL
                </span>

                <h1>
                    Order
                    <span class="gradient-text">
                        intelligence.
                    </span>
                </h1>

                <p>
                    Detail transaksi, pembayaran, dan kontrol status
                    pesanan RIJILL X MARKET.
                </p>

            </div>

            <a
                href="{{ route('admin.orders.index') }}"
                class="btn btn-secondary"
            >
                ← Back to Orders
            </a>

        </div>


        {{-- SUCCESS --}}
        @if (session('success'))

            <div class="order-detail-alert reveal">

                <span></span>

                {{ session('success') }}

            </div>

        @endif


        {{-- TOP STATUS --}}
        <div class="order-detail-top reveal">

            <div class="order-detail-code">

                <span>
                    ORDER IDENTIFICATION
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


            <div class="order-detail-created">

                <span>CREATED</span>

                <strong>
                    {{ $order->created_at->format('d M Y') }}
                </strong>

                <small>
                    {{ $order->created_at->format('H:i') }}
                </small>

            </div>


            <div class="order-detail-current">

                <span>CURRENT STATUS</span>

                <strong
                    class="
                        order-status-badge
                        order-status-{{ $order->status }}
                    "
                >

                    <span></span>

                    {{ strtoupper($order->status) }}

                </strong>

            </div>

        </div>


        <div class="order-detail-layout">

            {{-- LEFT --}}
            <div class="order-detail-main">


                {{-- CUSTOMER --}}
                <section class="order-detail-panel reveal">

                    <div class="order-detail-panel-head">

                        <div>

                            <span>
                                01 / CUSTOMER
                            </span>

                            <h2>
                                Customer information.
                            </h2>

                        </div>

                        <span class="order-panel-code">
                            RXM / DATA
                        </span>

                    </div>


                    <div class="customer-detail-grid">

                        <div class="customer-detail-item">

                            <span>
                                FULL NAME
                            </span>

                            <strong>
                                {{ $order->customer_name }}
                            </strong>

                        </div>


                        <div class="customer-detail-item">

                            <span>
                                EMAIL ADDRESS
                            </span>

                            <strong>
                                {{ $order->email }}
                            </strong>

                        </div>


                        <div class="customer-detail-item">

                            <span>
                                PHONE NUMBER
                            </span>

                            <strong>
                                {{ $order->phone }}
                            </strong>

                        </div>


                        <div class="customer-detail-item customer-address">

                            <span>
                                DELIVERY ADDRESS
                            </span>

                            <strong>
                                {{ $order->address }}
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- PAYMENT INFORMATION --}}
                <section class="order-detail-panel reveal">

                    <div class="order-detail-panel-head">

                        <div>

                            <span>
                                02 / PAYMENT
                            </span>

                            <h2>
                                Payment information.
                            </h2>

                        </div>

                        <span class="order-panel-code">
                            RXM / PAYMENT
                        </span>

                    </div>


                    <div class="admin-payment-information">

                        {{-- METHOD --}}
                        <div class="admin-payment-info-card">

                            <span class="admin-payment-label">
                                PAYMENT METHOD
                            </span>

                            <strong class="admin-payment-method">

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


                        {{-- STATUS --}}
                        <div class="admin-payment-info-card">

                            <span class="admin-payment-label">
                                PAYMENT STATUS
                            </span>

                            <strong
                                class="
                                    admin-payment-badge
                                    {{ $order->payment_status === 'paid'
                                        ? 'payment-paid'
                                        : 'payment-unpaid' }}
                                "
                            >

                                <span></span>

                                {{ strtoupper(
                                    $order->payment_status ?? 'unpaid'
                                ) }}

                            </strong>

                        </div>

                    </div>

                </section>


                {{-- ORDER ITEMS --}}
                <section class="order-detail-panel reveal">

                    <div class="order-detail-panel-head">

                        <div>

                            <span>
                                03 / ORDER ITEMS
                            </span>

                            <h2>
                                Purchased products.
                            </h2>

                        </div>

                        <span class="order-panel-code">
                            {{ $order->items->count() }} ITEM
                        </span>

                    </div>


                    <div class="order-item-list">

                        @foreach ($order->items as $item)

                            <div class="order-detail-item admin-order-item-with-image">


                                {{-- ITEM NUMBER --}}
                                <div class="order-item-number">

                                    {{ str_pad(
                                        $loop->iteration,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}

                                </div>


                                {{-- SNAPSHOT IMAGE --}}
                                <div class="admin-order-product-image">

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

                                        <div class="admin-order-image-placeholder">

                                            <span>
                                                RXM
                                            </span>

                                            <small>
                                                NO SNAPSHOT
                                            </small>

                                        </div>

                                    @endif

                                </div>


                                {{-- PRODUCT --}}
                                <div class="order-item-name">

                                    <span>
                                        PRODUCT
                                    </span>

                                    <strong>
                                        {{ $item->product_name }}
                                    </strong>


                                    <small class="admin-product-code">

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

                                    </small>

                                </div>


                                {{-- PRICE --}}
                                <div class="order-item-data">

                                    <span>
                                        PRICE
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
                                <div class="order-item-data">

                                    <span>
                                        QTY
                                    </span>

                                    <strong>
                                        {{ $item->quantity }}
                                    </strong>

                                </div>


                                {{-- SUBTOTAL --}}
                                <div class="order-item-data order-item-subtotal">

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

                            </div>

                        @endforeach

                    </div>

                </section>

            </div>


            {{-- RIGHT --}}
            <aside class="order-detail-side">


                {{-- ORDER STATUS CONTROL --}}
                <section class="order-status-control reveal">

                    <div class="order-control-live">

                        <span></span>

                        ORDER CONTROL ACTIVE

                    </div>


                    <span class="order-control-code">
                        RXM / STATUS SYSTEM
                    </span>


                    <h2>
                        Update
                        <span class="gradient-text">
                            status.
                        </span>
                    </h2>


                    <p>
                        Ubah status pesanan sesuai dengan
                        proses transaksi saat ini.
                    </p>


                    <form
                        action="{{ route(
                            'admin.orders.updateStatus',
                            $order
                        ) }}"
                        method="POST"
                        class="order-status-form"
                    >

                        @csrf
                        @method('PUT')


                        <label for="status">
                            ORDER STATUS
                        </label>


                        <select
                            name="status"
                            id="status"
                            required
                        >

                            <option
                                value="pending"
                                {{ $order->status === 'pending'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Pending
                            </option>

                            <option
                                value="diproses"
                                {{ $order->status === 'diproses'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Diproses
                            </option>

                            <option
                                value="dikirim"
                                {{ $order->status === 'dikirim'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Dikirim
                            </option>

                            <option
                                value="selesai"
                                {{ $order->status === 'selesai'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Selesai
                            </option>

                            <option
                                value="dibatalkan"
                                {{ $order->status === 'dibatalkan'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Dibatalkan
                            </option>

                        </select>


                        @error('status')

                            <div class="order-status-error">
                                {{ $message }}
                            </div>

                        @enderror


                        <button
                            type="submit"
                            class="order-status-button"
                        >

                            <span>
                                Update Status
                            </span>

                            <span>
                                →
                            </span>

                        </button>

                    </form>

                </section>


                {{-- PAYMENT CONTROL --}}
                <section class="order-status-control admin-payment-control reveal">

                    <div class="order-control-live payment-control-live">

                        <span></span>

                        PAYMENT CONTROL ACTIVE

                    </div>


                    <span class="order-control-code">
                        RXM / PAYMENT SYSTEM
                    </span>


                    <h2>
                        Payment
                        <span class="gradient-text">
                            status.
                        </span>
                    </h2>


                    <p>
                        Konfirmasi status pembayaran
                        untuk pesanan ini.
                    </p>


                    <div class="admin-current-payment">

                        <span>
                            CURRENT PAYMENT
                        </span>

                        <strong
                            class="
                                admin-payment-badge
                                {{ $order->payment_status === 'paid'
                                    ? 'payment-paid'
                                    : 'payment-unpaid' }}
                            "
                        >

                            <span></span>

                            {{ strtoupper(
                                $order->payment_status ?? 'unpaid'
                            ) }}

                        </strong>

                    </div>


                    <form
                        action="{{ route(
                            'admin.orders.updatePaymentStatus',
                            $order
                        ) }}"
                        method="POST"
                        class="order-status-form"
                    >

                        @csrf
                        @method('PUT')


                        <label for="payment_status">
                            PAYMENT STATUS
                        </label>


                        <select
                            name="payment_status"
                            id="payment_status"
                            required
                        >

                            <option
                                value="unpaid"
                                {{ $order->payment_status !== 'paid'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Unpaid
                            </option>

                            <option
                                value="paid"
                                {{ $order->payment_status === 'paid'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Paid
                            </option>

                        </select>


                        @error('payment_status')

                            <div class="order-status-error">
                                {{ $message }}
                            </div>

                        @enderror


                        <button
                            type="submit"
                            class="order-status-button"
                        >

                            <span>
                                Update Payment
                            </span>

                            <span>
                                →
                            </span>

                        </button>

                    </form>

                </section>


                {{-- SUMMARY --}}
                <section class="order-summary-admin reveal">

                    <span class="order-summary-label">
                        TRANSACTION SUMMARY
                    </span>


                    <div class="order-summary-row">

                        <span>
                            Items
                        </span>

                        <strong>
                            {{ $order->items->sum('quantity') }}
                        </strong>

                    </div>


                    <div class="order-summary-row">

                        <span>
                            Order ID
                        </span>

                        <strong>
                            #{{ $order->id }}
                        </strong>

                    </div>


                    <div class="order-summary-row">

                        <span>
                            Payment
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
                                    COD
                                    @break

                                @default
                                    -

                            @endswitch

                        </strong>

                    </div>


                    <div class="order-summary-row">

                        <span>
                            Payment Status
                        </span>

                        <strong
                            class="{{ $order->payment_status === 'paid'
                                ? 'summary-payment-paid'
                                : 'summary-payment-unpaid' }}"
                        >
                            {{ strtoupper(
                                $order->payment_status ?? 'unpaid'
                            ) }}
                        </strong>

                    </div>


                    <div class="order-summary-divider"></div>


                    <div class="order-summary-total">

                        <span>
                            TOTAL VALUE
                        </span>

                        <strong>

                            <small>
                                IDR
                            </small>

                            {{ number_format(
                                $order->total_price,
                                0,
                                ',',
                                '.'
                            ) }}

                        </strong>

                    </div>

                </section>

            </aside>

        </div>

    </div>

</section>


{{-- =====================================================
     ADMIN ORDER DETAIL ADDITIONAL STYLE
===================================================== --}}

<style>

/* =========================================================
   ORDER ITEM + SNAPSHOT IMAGE
========================================================= */

.admin-order-item-with-image {
    display: grid;

    grid-template-columns:
        45px
        90px
        minmax(150px, 1fr)
        120px
        60px
        140px;

    align-items: center;

    gap: 18px;
}


/* PRODUCT IMAGE */

.admin-order-product-image {
    width: 90px;
    height: 90px;

    overflow: hidden;

    flex-shrink: 0;

    border:
        1px solid rgba(255, 255, 255, .10);

    border-radius: 16px;

    background:
        rgba(255, 255, 255, .025);
}


.admin-order-product-image img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;
}


/* OLD ORDER FALLBACK */

.admin-order-image-placeholder {
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


.admin-order-image-placeholder span {
    color: #6fe8ff;

    font-size: 12px;
    font-weight: 800;

    letter-spacing: 2px;
}


.admin-order-image-placeholder small {
    color: #718096;

    font-size: 6px;
    font-weight: 800;

    letter-spacing: 1px;
}


/* PRODUCT CODE */

.admin-product-code {
    display: block;

    margin-top: 7px;

    color: #718096;

    font-size: 8px;
    font-weight: 800;

    letter-spacing: 1.2px;
}


/* =========================================================
   PAYMENT INFORMATION
========================================================= */

.admin-payment-information {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 14px;
}


.admin-payment-info-card {
    min-height: 105px;

    display: flex;
    flex-direction: column;

    justify-content: center;

    gap: 10px;

    padding: 20px;

    border:
        1px solid rgba(255, 255, 255, .08);

    border-radius: 16px;

    background:
        linear-gradient(
            135deg,
            rgba(255, 255, 255, .035),
            rgba(255, 255, 255, .015)
        );
}


.admin-payment-label {
    color: #718096;

    font-size: 8px;
    font-weight: 800;

    letter-spacing: 1.5px;
}


.admin-payment-method {
    color: #ffffff;

    font-size: 14px;
    font-weight: 800;

    letter-spacing: .6px;
}


/* PAYMENT BADGE */

.admin-payment-badge {
    width: fit-content;

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 8px 11px;

    border-radius: 999px;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 1.2px;
}


.admin-payment-badge > span {
    width: 6px;
    height: 6px;

    border-radius: 50%;
}


.admin-payment-badge.payment-unpaid {
    color: #ffb86c;

    border:
        1px solid rgba(255, 184, 108, .25);

    background:
        rgba(255, 184, 108, .07);
}


.admin-payment-badge.payment-unpaid > span {
    background: #ffb86c;

    box-shadow:
        0 0 10px rgba(255, 184, 108, .8);
}


.admin-payment-badge.payment-paid {
    color: #69f0ae;

    border:
        1px solid rgba(105, 240, 174, .25);

    background:
        rgba(105, 240, 174, .07);
}


.admin-payment-badge.payment-paid > span {
    background: #69f0ae;

    box-shadow:
        0 0 10px rgba(105, 240, 174, .8);
}


/* =========================================================
   PAYMENT CONTROL
========================================================= */

.admin-payment-control {
    margin-top: 18px;
}


.payment-control-live > span {
    background: #6fe8ff;

    box-shadow:
        0 0 10px rgba(111, 232, 255, .8);
}


.admin-current-payment {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin: 22px 0;

    padding: 14px;

    border:
        1px solid rgba(255, 255, 255, .08);

    border-radius: 14px;

    background:
        rgba(255, 255, 255, .025);
}


.admin-current-payment > span {
    color: #718096;

    font-size: 8px;
    font-weight: 800;

    letter-spacing: 1.3px;
}


/* SUMMARY PAYMENT */

.summary-payment-paid {
    color: #69f0ae !important;
}


.summary-payment-unpaid {
    color: #ffb86c !important;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1100px) {

    .admin-order-item-with-image {
        grid-template-columns:
            40px
            75px
            minmax(130px, 1fr)
            110px
            50px
            120px;

        gap: 12px;
    }


    .admin-order-product-image {
        width: 75px;
        height: 75px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 760px) {

    .admin-payment-information {
        grid-template-columns: 1fr;
    }


    .admin-order-item-with-image {
        grid-template-columns:
            80px
            minmax(0, 1fr);

        gap: 15px;
    }


    .admin-order-product-image {
        width: 80px;
        height: 80px;
    }


    .admin-order-item-with-image
    .order-item-number {
        display: none;
    }


    .admin-order-item-with-image
    .order-item-data {
        padding-top: 12px;

        border-top:
            1px solid rgba(255, 255, 255, .08);
    }


    .admin-order-item-with-image
    .order-item-subtotal {
        text-align: left;
    }


    .admin-current-payment {
        align-items: flex-start;

        flex-direction: column;
    }

}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 480px) {

    .admin-order-item-with-image {
        grid-template-columns: 1fr;
    }


    .admin-order-product-image {
        width: 100%;
        height: 200px;
    }

}

</style>

@endsection