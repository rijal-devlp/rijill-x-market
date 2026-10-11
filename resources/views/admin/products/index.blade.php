@extends('layouts.app')

@section('title', 'Inventory Control — RIJILL X MARKET')

@section('content')

<section class="inventory-page">

    <div class="container">

        {{-- HEADER --}}
        <div class="inventory-header reveal">

            <div>
                <span class="eyebrow">
                    RIJILL X MARKET / ADMIN / INVENTORY
                </span>

                <h1>
                    Product
                    <span class="gradient-text">inventory.</span>
                </h1>

                <p>
                    Kelola katalog, harga, stok, dan informasi
                    produk RIJILL X MARKET.
                </p>
            </div>

            <div class="inventory-header-actions">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="btn btn-secondary"
                >
                    ← Dashboard
                </a>

                <a
                    href="{{ route('admin.products.create') }}"
                    class="inventory-add-button"
                >
                    <span>Add Product</span>
                    <span class="inventory-add-icon">+</span>
                </a>

            </div>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div class="inventory-alert reveal">

                <span class="inventory-alert-dot"></span>

                {{ session('success') }}

            </div>

        @endif


        {{-- INVENTORY TOP BAR --}}
        <div class="inventory-control-bar reveal">

            <div class="inventory-control-status">

                <span class="inventory-live-dot"></span>

                <div>
                    <span>INVENTORY SYSTEM</span>

                    <strong>
                        {{ $products->count() }} PRODUCTS ACTIVE
                    </strong>
                </div>

            </div>

            <div class="inventory-control-code">
                RXM / INVENTORY / LIVE
            </div>

        </div>


        {{-- PRODUCTS --}}
        @if ($products->count() > 0)

            <div class="inventory-grid">

                @foreach ($products as $product)

                    <article class="inventory-card reveal">

                        {{-- IMAGE --}}
                        <div class="inventory-image">

                            @if ($product->image)

                                <img
                                    src="{{ asset(
                                        'storage/' . $product->image
                                    ) }}"
                                    alt="{{ $product->name }}"
                                >

                            @else

                                <div class="inventory-no-image">
                                    <strong>RXM</strong>
                                    <span>NO VISUAL</span>
                                </div>

                            @endif


                            <div class="inventory-image-top">

                                <span>
                                    RJL /
                                    {{ str_pad(
                                        $product->id,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </span>

                                @if ($product->stock > 5)

                                    <span class="inventory-stock available">
                                        IN STOCK
                                    </span>

                                @elseif ($product->stock > 0)

                                    <span class="inventory-stock low">
                                        LOW STOCK
                                    </span>

                                @else

                                    <span class="inventory-stock empty">
                                        SOLD OUT
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- CONTENT --}}
                        <div class="inventory-content">

                            <div class="inventory-category">
                                {{ strtoupper($product->category->name) }}
                            </div>

                            <h2>
                                {{ $product->name }}
                            </h2>

                            <p class="inventory-description">
                                {{ $product->description ?: 'No product description.' }}
                            </p>


                            <div class="inventory-data">

                                <div>
                                    <span>PRICE</span>

                                    <strong>
                                        IDR
                                        {{ number_format(
                                            $product->price,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </strong>
                                </div>

                                <div>
                                    <span>STOCK</span>

                                    <strong>
                                        {{ $product->stock }}
                                        UNIT
                                    </strong>
                                </div>

                            </div>


                            {{-- ACTIONS --}}
                            <div class="inventory-actions">

                                <a
                                    href="{{ route(
                                        'admin.products.edit',
                                        $product
                                    ) }}"
                                    class="inventory-edit"
                                >
                                    <span>Edit Product</span>
                                    <span>→</span>
                                </a>


                                <form
                                    action="{{ route(
                                        'admin.products.destroy',
                                        $product
                                    ) }}"
                                    method="POST"
                                    class="inventory-delete-form"
                                    onsubmit="
                                        return confirm(
                                            'Hapus produk ini?'
                                        );
                                    "
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inventory-delete"
                                        aria-label="Delete product"
                                    >
                                        ×
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="inventory-empty reveal">

                <div class="inventory-empty-orbit">
                    <span>+</span>
                </div>

                <span>RXM / EMPTY INVENTORY</span>

                <h2>
                    No products
                    <span class="gradient-text">detected.</span>
                </h2>

                <p>
                    Inventory masih kosong. Tambahkan produk
                    pertama ke RIJILL X MARKET.
                </p>

                <a
                    href="{{ route('admin.products.create') }}"
                    class="btn btn-primary"
                >
                    Add First Product →
                </a>

            </div>

        @endif

    </div>

</section>

@endsection