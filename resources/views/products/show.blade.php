@extends('layouts.app')

@section('title', $product->name . ' — RIJILL MARKET')

@section('content')

<section class="product-detail-page">

    <div class="container">

        {{-- BREADCRUMB --}}
        <div class="product-breadcrumb reveal">

            <a href="{{ route('products.index') }}">
                RIJILL MARKET
            </a>

            <span>/</span>

            <span>
                {{ $product->category->name }}
            </span>

            <span>/</span>

            <span class="current">
                {{ $product->name }}
            </span>

        </div>


        {{-- PRODUCT DETAIL --}}
        <div class="product-detail-grid">

            {{-- =========================
                 PRODUCT VISUAL
            ========================== --}}

            <div class="product-detail-visual reveal">

                <div class="detail-visual-code">
                    RJM /
                    {{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}
                </div>


                @if ($product->image)

                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="detail-product-image"
                    >

                @else

                    <div class="detail-product-placeholder">

                        <strong>
                            RJL
                        </strong>

                        <span>
                            VISUAL UNAVAILABLE
                        </span>

                    </div>

                @endif


                <div class="detail-visual-bottom">

                    <span>
                        RIJILL MARKET
                    </span>

                    <span>
                        FUTURE COLLECTION
                    </span>

                </div>

            </div>


            {{-- =========================
                 PRODUCT INFORMATION
            ========================== --}}

            <div class="product-detail-info reveal">

                <div class="detail-category">
                    {{ $product->category->name }}
                </div>


                <h1>
                    {{ $product->name }}
                </h1>


                <div class="detail-price">

                    <span>
                        IDR
                    </span>

                    <strong>
                        {{ number_format(
                            $product->price,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                {{-- STOCK --}}

                <div class="detail-stock">

                    @if ($product->stock > 0)

                        <span class="detail-stock-dot"></span>

                        <span>
                            AVAILABLE
                        </span>

                        <strong>
                            {{ $product->stock }} UNIT
                        </strong>

                    @else

                        <span class="detail-stock-empty">
                            SOLD OUT
                        </span>

                    @endif

                </div>


                <div class="detail-divider"></div>


                {{-- DESCRIPTION --}}

                <div class="detail-description">

                    <span class="detail-label">
                        PRODUCT INFORMATION
                    </span>

                    <p>
                        {{ $product->description ?: 'Belum ada deskripsi untuk produk ini.' }}
                    </p>

                </div>


                {{-- ADD TO CART --}}

                @if ($product->stock > 0)

                    <form
                        action="{{ route('cart.add', $product) }}"
                        method="POST"
                        class="detail-cart-form"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="detail-add-cart"
                        >

                            <span>
                                Add to Cart
                            </span>

                            <span class="detail-button-arrow">
                                →
                            </span>

                        </button>

                    </form>

                @else

                    <button
                        type="button"
                        class="detail-add-cart disabled"
                        disabled
                    >

                        <span>
                            Currently Unavailable
                        </span>

                        <span>
                            ×
                        </span>

                    </button>

                @endif


                {{-- INFORMATION GRID --}}

                <div class="detail-meta">

                    <div>

                        <span>
                            CATEGORY
                        </span>

                        <strong>
                            {{ $product->category->name }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            PRODUCT ID
                        </span>

                        <strong>
                            RJL-{{ str_pad(
                                $product->id,
                                4,
                                '0',
                                STR_PAD_LEFT
                            ) }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            STATUS
                        </span>

                        <strong>
                            {{ $product->stock > 0 ? 'Ready' : 'Sold Out' }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
             BOTTOM SECTION
        ========================== --}}

        <div class="detail-bottom-section reveal">

            <div>

                <span class="eyebrow">
                    RIJILL MARKET / PRODUCT
                </span>

                <h2>
                    Designed for
                    <span class="gradient-text">
                        what's next.
                    </span>
                </h2>

            </div>


            <a
                href="{{ route('products.index') }}"
                class="btn btn-secondary"
            >
                ← Back to Collection
            </a>

        </div>

    </div>

</section>

@endsection