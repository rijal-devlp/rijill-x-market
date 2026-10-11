@extends('layouts.app')

@section('title', 'RIJILL MARKET — Future Commerce')

@section('content')

{{-- =========================================================
     HERO
========================================================= --}}

<section class="hero">

    <div class="container hero-grid">

        <div class="hero-content reveal">

            <span class="eyebrow">
                Future Commerce / 2026
            </span>

            <h1 class="display-title">
                Shop beyond
                <span class="gradient-text">
                    tomorrow.
                </span>
            </h1>

            <p class="hero-description">
                Temukan produk pilihan dalam pengalaman belanja
                digital yang dirancang untuk generasi berikutnya.
            </p>

            <div class="hero-actions">

                <a href="#products" class="btn btn-primary">
                    Explore Products
                    <span>→</span>
                </a>

                <a href="{{ route('cart.index') }}"
                   class="btn btn-secondary">
                    View Cart
                </a>

            </div>

            <div class="hero-stats">

                <div>
                    <strong>{{ $products->count() }}</strong>
                    <span>Products</span>
                </div>

                <div>
                    <strong>24/7</strong>
                    <span>Digital Store</span>
                </div>

                <div>
                    <strong>∞</strong>
                    <span>Possibilities</span>
                </div>

            </div>

        </div>


        {{-- FUTURE VISUAL --}}

        <div class="hero-visual reveal">

            <div class="future-orb">

                <div class="orb-core"></div>

                <div class="orb-ring orb-ring-one"></div>

                <div class="orb-ring orb-ring-two"></div>

                <div class="orb-ring orb-ring-three"></div>

                <div class="floating-tag tag-one">
                    <span></span>
                    NEW ERA
                </div>

                <div class="floating-tag tag-two">
                    RJL / 26
                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     DISCOVERY
========================================================= --}}

<section class="discovery">

    <div class="container">

        <div class="discovery-panel glass reveal">

            <div>

                <span class="discovery-label">
                    DISCOVER
                </span>

                <h2>
                    What are you looking for?
                </h2>

            </div>

            <div class="future-search">

                <span class="search-icon">
                    ⌕
                </span>

                <input
                    type="text"
                    id="productSearch"
                    placeholder="Search the next thing..."
                    autocomplete="off"
                >

                <span class="search-command">
                    RJL
                </span>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     PRODUCTS
========================================================= --}}

<section
    class="products-section"
    id="products"
>

    <div class="container">

       <div class="section-heading reveal">

    <div>

        <span class="eyebrow">
            Selected Objects
        </span>

        <h2 class="section-title">
            Future collection.
        </h2>

    </div>

    <p>
        Produk yang tersedia di RIJILL X MARKET saat ini.
        Pilih kategori untuk menemukan produk yang kamu inginkan.
    </p>

</div>


{{-- CATEGORY FILTER --}}
<div class="category-filter reveal" id="categoryFilter">

    <button
        type="button"
        class="category-filter-btn active"
        data-category-filter="all"
    >
        ALL COLLECTIONS
    </button>

    @foreach ($products->pluck('category')->filter()->unique('id') as $category)

        <button
            type="button"
            class="category-filter-btn"
            data-category-filter="{{ strtolower($category->name) }}"
        >
            {{ strtoupper($category->name) }}
        </button>

    @endforeach

</div>


        @if ($products->count() > 0)

            <div
                class="product-grid"
                id="productGrid"
            >

                @foreach ($products as $product)

                    <article
                        class="product-card reveal"
                        data-product-name="{{ strtolower($product->name) }}"
                        data-category="{{ strtolower($product->category->name) }}"
                    >

                        <a
                            href="{{ route('products.show', $product) }}"
                            class="product-image-area"
                        >

                            <div class="product-top">

                                <span class="product-category">
                                    {{ $product->category->name }}
                                </span>

                                @if ($product->stock > 0)

                                    <span class="stock-indicator">
                                        <span></span>
                                        IN STOCK
                                    </span>

                                @else

                                    <span class="stock-indicator sold-out">
                                        SOLD OUT
                                    </span>

                                @endif

                            </div>


                            @if ($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-image"
                                >

                            @else

                                <div class="product-placeholder">

                                    <span>
                                        RJL
                                    </span>

                                    <small>
                                        NO VISUAL
                                    </small>

                                </div>

                            @endif


                            <div class="product-number">
                                RJL /
                                {{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}
                            </div>

                        </a>


                        <div class="product-info">

                            <div>

                                <h3>
                                    <a href="{{ route('products.show', $product) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <p>
                                    {{ $product->description ?: 'Future selected product.' }}
                                </p>

                            </div>


                            <div class="product-bottom">

                                <div class="product-price">

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

                                <a
                                    href="{{ route('products.show', $product) }}"
                                    class="product-arrow"
                                    aria-label="Lihat {{ $product->name }}"
                                >
                                    ↗
                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


            <div
                class="no-results"
                id="noResults"
            >

                <span>RJL / SEARCH</span>

                <h3>
                    Nothing found in this dimension.
                </h3>

                <p>
                    Coba gunakan nama produk atau kategori lainnya.
                </p>

            </div>

        @else

            <div class="empty-products glass">

                <span>RJL / EMPTY</span>

                <h2>
                    The collection is being prepared.
                </h2>

                <p>
                    Belum ada produk yang tersedia.
                </p>

            </div>

        @endif

    </div>

</section>


{{-- =========================================================
     FUTURE BANNER
========================================================= --}}

<section class="future-banner">

    <div class="container">

        <div class="future-banner-inner reveal">

            <div class="banner-grid"></div>

            <span class="eyebrow">
                RIJILL MARKET SYSTEM
            </span>

            <h2>
                Commerce is changing.
                <span class="gradient-text">
                    So are we.
                </span>
            </h2>

            <p>
                Sebuah eksperimen tentang bagaimana pengalaman
                belanja digital masa depan dapat terasa lebih
                sederhana, personal, dan imersif.
            </p>

            <a
                href="#products"
                class="btn btn-primary"
            >
                Enter Collection
            </a>

        </div>

    </div>

</section>

@endsection