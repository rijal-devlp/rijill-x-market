@extends('layouts.app')

@section('title', 'Order Confirmed — RIJILL X MARKET')

@section('content')

<section class="success-page">

    <div class="container">

        <div class="success-card reveal">

            {{-- VISUAL --}}
            <div class="success-visual">

                <div class="success-orbit">
                    <div class="success-ring ring-a"></div>
                    <div class="success-ring ring-b"></div>

                    <div class="success-check">
                        ✓
                    </div>
                </div>

                <span class="success-system">
                    RJL / ORDER SYSTEM
                </span>

            </div>


            {{-- CONTENT --}}
            <div class="success-content">

                <div class="success-status">
                    <span></span>
                    ORDER CONFIRMED
                </div>

                <h1>
                    Order
                    <span class="gradient-text">
                        received.
                    </span>
                </h1>

                <p class="success-description">
                    Terima kasih. Pesananmu berhasil masuk ke
                    sistem RIJILL X MARKET dan sedang menunggu
                    proses selanjutnya.
                </p>


                {{-- ORDER ID --}}
                <div class="success-order-id">

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


                {{-- CUSTOMER + ORDER INFORMATION --}}
                <div class="success-info-grid">

                    <div>
                        <span>CUSTOMER</span>

                        <strong>
                            {{ $order->customer_name }}
                        </strong>
                    </div>

                    <div>
                        <span>ORDER STATUS</span>

                        <strong class="success-pending">
                            {{ strtoupper($order->status) }}
                        </strong>
                    </div>

                    <div>
                        <span>EMAIL</span>

                        <strong>
                            {{ $order->email }}
                        </strong>
                    </div>

                    <div>
                        <span>PHONE</span>

                        <strong>
                            {{ $order->phone }}
                        </strong>
                    </div>


                    {{-- PAYMENT METHOD --}}
                    <div>
                        <span>PAYMENT METHOD</span>

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
                    <div>
                        <span>PAYMENT STATUS</span>

                        <strong
                            class="{{ $order->payment_status === 'paid'
                                ? 'success-paid'
                                : 'success-unpaid' }}"
                        >
                            {{ strtoupper(
                                $order->payment_status ?? 'unpaid'
                            ) }}
                        </strong>
                    </div>

                </div>


                {{-- ITEMS --}}
                <div class="success-products">

                    <div class="success-products-title">

                        <span>
                            ORDER CONTENT
                        </span>

                        <span>
                            {{ $order->items->sum('quantity') }}
                            ITEM
                        </span>

                    </div>


                    @foreach ($order->items as $item)

                        <div class="success-product-row">

                            <div>

                                <span class="success-product-code">

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

                                </span>

                                <strong>
                                    {{ $item->product_name }}
                                </strong>

                                <small>
                                    QTY {{ $item->quantity }}
                                </small>

                            </div>


                            <strong class="success-product-price">
                                IDR
                                {{ number_format(
                                    $item->subtotal,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>

                        </div>

                    @endforeach

                </div>


                {{-- TOTAL --}}
                <div class="success-total">

                    <div>
                        <span>
                            TOTAL ORDER
                        </span>

                        <small>
                            Final recorded value
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


                {{-- ACTION --}}
                <div class="success-actions">

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-primary"
                    >
                        Continue Exploring →
                    </a>

                    @auth

                        @if (Auth::user()->role === 'admin')

                            <a
                                href="{{ route(
                                    'admin.orders.show',
                                    $order
                                ) }}"
                                class="btn btn-secondary"
                            >
                                View in Admin
                            </a>

                        @endif

                    @endauth

                </div>

            </div>

        </div>

    </div>

</section>


<style>

    /*
    |--------------------------------------------------------------------------
    | PAYMENT STATUS
    |--------------------------------------------------------------------------
    */

    .success-paid {
        color: #69f0ae !important;
    }

    .success-unpaid {
        color: #ffb86c !important;
    }

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    sessionStorage.removeItem('rijill_cart_selection');
});
</script>

@endsection