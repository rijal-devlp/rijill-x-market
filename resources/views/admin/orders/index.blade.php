@extends('layouts.app')

@section('title', 'Order Control — RIJILL X MARKET')

@section('content')

<section class="order-admin-page">

    <div class="container">

        {{-- HEADER --}}
        <div class="order-admin-header reveal">

            <div>
                <span class="eyebrow">
                    RIJILL X MARKET / ADMIN / ORDERS
                </span>

                <h1>
                    Order
                    <span class="gradient-text">
                        control.
                    </span>
                </h1>

                <p>
                    Pantau seluruh transaksi dan status pesanan
                    RIJILL X MARKET dari satu pusat kendali.
                </p>
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="btn btn-secondary"
            >
                ← Dashboard
            </a>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div class="order-admin-alert reveal">

                <span></span>

                {{ session('success') }}

            </div>

        @endif


        {{-- SYSTEM BAR --}}
        <div class="order-system-bar reveal">

            <div class="order-system-left">

                <span class="order-system-dot"></span>

                <div>
                    <small>ORDER SYSTEM</small>

                    <strong>
                        {{ $orders->count() }}
                        TRANSACTIONS DETECTED
                    </strong>
                </div>

            </div>

            <div class="order-system-code">
                RXM / ORDER NETWORK / LIVE
            </div>

        </div>


        {{-- ORDERS --}}
        @if ($orders->count() > 0)

            <div class="order-admin-panel reveal">

                <div class="order-admin-table-head">

                    <span>ORDER ID</span>
                    <span>CUSTOMER</span>
                    <span>VALUE</span>
                    <span>STATUS</span>
                    <span>DATE</span>
                    <span>ACTION</span>

                </div>


                <div class="order-admin-list">

                    @foreach ($orders as $order)

                        <div class="order-admin-row">

                            {{-- ID --}}
                            <div class="order-admin-id">

                                <span>ORDER</span>

                                <strong>
                                    RJL-{{ str_pad(
                                        $order->id,
                                        6,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </strong>

                            </div>


                            {{-- CUSTOMER --}}
                            <div class="order-admin-customer">

                                <div class="order-customer-avatar">
                                    {{ strtoupper(
                                        substr(
                                            $order->customer_name,
                                            0,
                                            1
                                        )
                                    ) }}
                                </div>

                                <div>
                                    <strong>
                                        {{ $order->customer_name }}
                                    </strong>

                                    <span>
                                        {{ $order->email }}
                                    </span>
                                </div>

                            </div>


                            {{-- VALUE --}}
                            <div class="order-admin-value">

                                <span>IDR</span>

                                <strong>
                                    {{ number_format(
                                        $order->total_price,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </strong>

                            </div>


                            {{-- STATUS --}}
                            <div>

                                <span
                                    class="
                                        order-status-badge
                                        order-status-{{ $order->status }}
                                    "
                                >

                                    <span></span>

                                    {{ strtoupper(
                                        $order->status
                                    ) }}

                                </span>

                            </div>


                            {{-- DATE --}}
                            <div class="order-admin-date">

                                <strong>
                                    {{ $order->created_at
                                        ->format('d M Y') }}
                                </strong>

                                <span>
                                    {{ $order->created_at
                                        ->format('H:i') }}
                                </span>

                            </div>


                            {{-- ACTION --}}
                            <div>

                                <a
                                    href="{{ route(
                                        'admin.orders.show',
                                        $order
                                    ) }}"
                                    class="order-admin-open"
                                >
                                    <span>Open</span>
                                    <span>→</span>
                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @else

            {{-- EMPTY --}}
            <div class="order-admin-empty reveal">

                <div class="order-empty-orbit">
                    <span>◇</span>
                </div>

                <span>
                    RXM / NO TRANSACTIONS
                </span>

                <h2>
                    No orders
                    <span class="gradient-text">
                        detected.
                    </span>
                </h2>

                <p>
                    Belum ada transaksi yang masuk ke
                    RIJILL X MARKET.
                </p>

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-primary"
                >
                    View Store →
                </a>

            </div>

        @endif

    </div>

</section>

@endsection