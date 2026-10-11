@extends('layouts.app')

@section('title', 'Admin Control Center — RIJILL X MARKET')

@section('content')

<section class="admin-dashboard">

    <div class="container">

        {{-- HEADER --}}
        <div class="admin-dashboard-header reveal">

            <div>
                <div class="admin-live">
                    <span></span>
                    SYSTEM ONLINE
                </div>

                <span class="eyebrow">
                    RIJILL X MARKET / ADMIN SYSTEM
                </span>

                <h1>
                    Commerce
                    <span class="gradient-text">
                        control.
                    </span>
                </h1>

                <p>
                    Monitor produk, pesanan, dan aktivitas
                    RIJILL X MARKET dari satu pusat kendali.
                </p>
            </div>


            <div class="admin-header-actions">

                <div class="admin-identity">
                    <span>ADMIN ACCESS</span>

                    <strong>
                        {{ Auth::user()->name }}
                    </strong>
                </div>

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-secondary"
                >
                    View Store ↗
                </a>

            </div>

        </div>


        {{-- ================================================
             STATISTICS
        ================================================= --}}

        <div class="admin-stats">

            <div class="admin-stat-card reveal">

                <div class="admin-stat-top">
                    <span>01 / INVENTORY</span>
                    <span class="admin-stat-icon">◇</span>
                </div>

                <strong>
                    {{ $totalProducts }}
                </strong>

                <p>
                    Total Products
                </p>

                <div class="admin-stat-line"></div>

                <small>
                    ACTIVE CATALOG
                </small>

            </div>


            <div class="admin-stat-card reveal">

                <div class="admin-stat-top">
                    <span>02 / ORDERS</span>
                    <span class="admin-stat-icon">↗</span>
                </div>

                <strong>
                    {{ $totalOrders }}
                </strong>

                <p>
                    Total Orders
                </p>

                <div class="admin-stat-line"></div>

                <small>
                    ALL TRANSACTIONS
                </small>

            </div>


            <div class="admin-stat-card reveal">

                <div class="admin-stat-top">
                    <span>03 / PENDING</span>

                    <span class="admin-pending-dot"></span>
                </div>

                <strong>
                    {{ $pendingOrders }}
                </strong>

                <p>
                    Waiting Orders
                </p>

                <div class="admin-stat-line"></div>

                <small>
                    NEEDS ATTENTION
                </small>

            </div>


            <div class="admin-stat-card admin-revenue-card reveal">

                <div class="admin-stat-top">
                    <span>04 / REVENUE</span>
                    <span class="admin-stat-icon">+</span>
                </div>

                <strong class="admin-revenue">
                    <small>IDR</small>

                    {{ number_format(
                        $totalRevenue,
                        0,
                        ',',
                        '.'
                    ) }}
                </strong>

                <p>
                    Completed Revenue
                </p>

                <div class="admin-stat-line"></div>

                <small>
                    COMPLETED ORDERS ONLY
                </small>

            </div>

        </div>


        {{-- ================================================
             MAIN ADMIN AREA
        ================================================= --}}

        <div class="admin-main-grid">


            {{-- ORDER PIPELINE --}}
            <div class="admin-panel reveal">

                <div class="admin-panel-header">

                    <div>
                        <span>
                            ORDER PIPELINE
                        </span>

                        <h2>
                            Live status.
                        </h2>
                    </div>

                    <span class="admin-panel-code">
                        RXM / 01
                    </span>

                </div>


                <div class="admin-pipeline">

                    <div class="pipeline-item">

                        <div class="pipeline-number">
                            {{ $pendingOrders }}
                        </div>

                        <div class="pipeline-info">
                            <strong>Pending</strong>
                            <span>Waiting for processing</span>
                        </div>

                        <span class="pipeline-status pending">
                            WAIT
                        </span>

                    </div>


                    <div class="pipeline-item">

                        <div class="pipeline-number">
                            {{ $processedOrders }}
                        </div>

                        <div class="pipeline-info">
                            <strong>Diproses</strong>
                            <span>Order being prepared</span>
                        </div>

                        <span class="pipeline-status process">
                            LIVE
                        </span>

                    </div>


                    <div class="pipeline-item">

                        <div class="pipeline-number">
                            {{ $shippedOrders }}
                        </div>

                        <div class="pipeline-info">
                            <strong>Dikirim</strong>
                            <span>Order in delivery</span>
                        </div>

                        <span class="pipeline-status shipping">
                            MOVE
                        </span>

                    </div>


                    <div class="pipeline-item">

                        <div class="pipeline-number">
                            {{ $completedOrders }}
                        </div>

                        <div class="pipeline-info">
                            <strong>Selesai</strong>
                            <span>Transaction completed</span>
                        </div>

                        <span class="pipeline-status complete">
                            DONE
                        </span>

                    </div>

                </div>

            </div>


            {{-- QUICK ACCESS --}}
            <div class="admin-panel admin-quick-panel reveal">

                <div class="admin-panel-header">

                    <div>
                        <span>
                            CONTROL ACCESS
                        </span>

                        <h2>
                            Quick actions.
                        </h2>
                    </div>

                    <span class="admin-panel-code">
                        RXM / 02
                    </span>

                </div>


                <div class="admin-quick-actions">

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="admin-action"
                    >
                        <div>
                            <span>
                                PRODUCT SYSTEM
                            </span>

                            <strong>
                                Manage Products
                            </strong>

                            <small>
                                Add, edit and manage inventory
                            </small>
                        </div>

                        <span class="admin-action-arrow">
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="admin-action"
                    >
                        <div>
                            <span>
                                ORDER SYSTEM
                            </span>

                            <strong>
                                Manage Orders
                            </strong>

                            <small>
                                Monitor and update order status
                            </small>
                        </div>

                        <span class="admin-action-arrow">
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('products.index') }}"
                        class="admin-action"
                    >
                        <div>
                            <span>
                                PUBLIC STORE
                            </span>

                            <strong>
                                Open Storefront
                            </strong>

                            <small>
                                Preview customer experience
                            </small>
                        </div>

                        <span class="admin-action-arrow">
                            ↗
                        </span>
                    </a>

                </div>

            </div>

        </div>


        {{-- ================================================
             LATEST ORDERS
        ================================================= --}}

        <div class="admin-latest reveal">

            <div class="admin-latest-header">

                <div>
                    <span>
                        RECENT ACTIVITY
                    </span>

                    <h2>
                        Latest orders.
                    </h2>
                </div>

                <a href="{{ route('admin.orders.index') }}">
                    View all orders →
                </a>

            </div>


            @if ($latestOrders->count() > 0)

                <div class="admin-order-table">

                    <div class="admin-order-table-head">

                        <span>ORDER</span>
                        <span>CUSTOMER</span>
                        <span>VALUE</span>
                        <span>STATUS</span>
                        <span>DATE</span>
                        <span></span>

                    </div>


                    @foreach ($latestOrders as $order)

                        <div class="admin-order-row">

                            <strong>
                                RJL-{{ str_pad(
                                    $order->id,
                                    6,
                                    '0',
                                    STR_PAD_LEFT
                                ) }}
                            </strong>

                            <span>
                                {{ $order->customer_name }}
                            </span>

                            <span>
                                IDR
                                {{ number_format(
                                    $order->total_price,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </span>


                            <span
                                class="admin-order-status
                                status-{{ $order->status }}"
                            >
                                {{ strtoupper($order->status) }}
                            </span>


                            <span>
                                {{ $order->created_at->format('d M Y') }}
                            </span>


                            <a
                                href="{{ route(
                                    'admin.orders.show',
                                    $order
                                ) }}"
                                class="admin-order-open"
                            >
                                →
                            </a>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="admin-empty">
                    No order activity detected.
                </div>

            @endif

        </div>

    </div>

</section>

@endsection