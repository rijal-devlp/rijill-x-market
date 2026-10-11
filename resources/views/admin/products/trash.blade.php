@extends('layouts.app')

@section('title', 'Product Trash — RIJILL X MARKET')

@section('content')

<section class="trash-page">

    <div class="container">

        {{-- HEADER --}}
        <div class="trash-header">

            <div>
                <span class="trash-eyebrow">
                    RIJILL X MARKET / ADMIN SYSTEM
                </span>

                <h1>
                    Product
                    <span class="gradient-text">
                        Trash.
                    </span>
                </h1>

                <p>
                    Produk yang dihapus dari Collection akan
                    disimpan sementara di sini dan dapat
                    dikembalikan kapan saja.
                </p>
            </div>


            <div class="trash-header-actions">

                <a
                    href="{{ route('admin.products.index') }}"
                    class="trash-back-button"
                >
                    ← Back to Collection
                </a>

            </div>

        </div>


        {{-- INFORMATION --}}
        <div class="trash-information">

            <div class="trash-info-icon">
                ↺
            </div>

            <div>
                <strong>
                    Safe Delete System
                </strong>

                <p>
                    Restore akan mengembalikan produk ke Collection.
                    Delete Permanently akan menghapus produk dan
                    file gambarnya secara permanen.
                </p>
            </div>

        </div>


        {{-- PRODUCTS --}}
        @if ($products->count() > 0)

            <div class="trash-count">

                <span>
                    ARCHIVED PRODUCTS
                </span>

                <strong>
                    {{ $products->count() }}
                </strong>

            </div>


            <div class="trash-grid">

                @foreach ($products as $product)

                    <article class="trash-card">

                        {{-- IMAGE --}}
                        <div class="trash-image">

                            @if ($product->image)

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $product->image
                                    ) }}"
                                    alt="{{ $product->name }}"
                                >

                            @else

                                <div class="trash-no-image">
                                    <span>
                                        NO IMAGE
                                    </span>
                                </div>

                            @endif


                            <div class="trash-badge">
                                TRASH
                            </div>

                        </div>


                        {{-- CONTENT --}}
                        <div class="trash-content">

                            <div class="trash-product-meta">

                                <span>
                                    RJL /
                                    {{ str_pad(
                                        $product->id,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </span>


                                <span>
                                    {{ $product->category?->name
                                        ?? 'NO CATEGORY' }}
                                </span>

                            </div>


                            <h2>
                                {{ $product->name }}
                            </h2>


                            <div class="trash-details">

                                <div>

                                    <span>
                                        PRICE
                                    </span>

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

                                    <span>
                                        STOCK
                                    </span>

                                    <strong>
                                        {{ $product->stock }}
                                    </strong>

                                </div>

                            </div>


                            <div class="trash-deleted-date">

                                <span>
                                    DELETED
                                </span>

                                <strong>
                                    {{ $product->deleted_at
                                        ?->format(
                                            'd M Y · H:i'
                                        ) }}
                                </strong>

                            </div>


                            {{-- ACTIONS --}}
                            <div class="trash-actions">

                                {{-- RESTORE --}}
                                <form
                                    action="{{ route(
                                        'admin.products.restore',
                                        $product->id
                                    ) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="restore-button"
                                    >
                                        <span>
                                            ↺
                                        </span>

                                        Restore
                                    </button>

                                </form>


                                {{-- PERMANENT DELETE --}}
                                <form
                                    action="{{ route(
                                        'admin.products.forceDelete',
                                        $product->id
                                    ) }}"
                                    method="POST"
                                    onsubmit="
                                        return confirm(
                                            'Hapus produk ini secara permanen? Tindakan ini tidak dapat dibatalkan.'
                                        );
                                    "
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="permanent-delete-button"
                                    >
                                        Delete Permanently
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


        @else

            {{-- EMPTY TRASH --}}
            <div class="trash-empty">

                <div class="trash-empty-icon">
                    ✓
                </div>

                <span>
                    RIJILL X MARKET / CLEAN SYSTEM
                </span>

                <h2>
                    Trash is empty.
                </h2>

                <p>
                    Tidak ada produk yang sedang berada
                    di Trash.
                </p>

                <a
                    href="{{ route(
                        'admin.products.index'
                    ) }}"
                    class="trash-back-button"
                >
                    Back to Collection
                </a>

            </div>

        @endif

    </div>

</section>


<style>

/* ========================================
   PRODUCT TRASH
======================================== */

.trash-page {
    min-height: 100vh;
    padding: 70px 0 120px;
}


/* HEADER */

.trash-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;

    gap: 40px;

    margin-bottom: 35px;
}

.trash-eyebrow {
    display: inline-block;

    margin-bottom: 15px;

    color: #6fe8ff;

    font-size: 10px;
    font-weight: 800;

    letter-spacing: 3px;
}

.trash-header h1 {
    margin: 0;

    font-size: clamp(
        48px,
        7vw,
        88px
    );

    line-height: .95;

    letter-spacing: -4px;
}

.trash-header p {
    max-width: 580px;

    margin: 20px 0 0;

    color: var(--muted);

    font-size: 14px;
    line-height: 1.7;
}

.trash-header-actions {
    flex-shrink: 0;
}

.trash-back-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 44px;

    padding: 0 18px;

    border: 1px solid var(--border);
    border-radius: 12px;

    background:
        rgba(255,255,255,.025);

    color: var(--text);

    text-decoration: none;

    font-size: 12px;
    font-weight: 700;

    transition: .2s ease;
}

.trash-back-button:hover {
    border-color:
        rgba(111,232,255,.35);

    color: #6fe8ff;

    transform: translateY(-2px);
}


/* INFORMATION */

.trash-information {
    display: flex;
    align-items: center;

    gap: 18px;

    margin-bottom: 35px;

    padding: 20px 22px;

    border:
        1px solid rgba(111,232,255,.14);

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            rgba(111,232,255,.05),
            rgba(255,255,255,.015)
        );
}

.trash-info-icon {
    width: 44px;
    height: 44px;

    flex: 0 0 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background:
        rgba(111,232,255,.08);

    color: #6fe8ff;

    font-size: 22px;
}

.trash-information strong {
    display: block;

    margin-bottom: 4px;

    font-size: 13px;
}

.trash-information p {
    margin: 0;

    color: var(--muted);

    font-size: 12px;
    line-height: 1.6;
}


/* COUNT */

.trash-count {
    display: flex;
    align-items: center;

    gap: 10px;

    margin-bottom: 15px;

    color: #718096;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 2px;
}

.trash-count strong {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-width: 25px;
    height: 25px;

    padding: 0 7px;

    border-radius: 50px;

    background:
        rgba(111,232,255,.08);

    color: #6fe8ff;
}


/* GRID */

.trash-grid {
    display: grid;

    grid-template-columns:
        repeat(
            3,
            minmax(0, 1fr)
        );

    gap: 22px;
}


/* CARD */

.trash-card {
    overflow: hidden;

    border: 1px solid var(--border);

    border-radius: 24px;

    background:
        rgba(255,255,255,.02);

    transition:
        transform .25s ease,
        border-color .25s ease;
}

.trash-card:hover {
    transform: translateY(-4px);

    border-color:
        rgba(111,232,255,.25);
}


/* IMAGE */

.trash-image {
    position: relative;

    width: 100%;
    height: 230px;

    overflow: hidden;

    background:
        rgba(255,255,255,.025);
}

.trash-image img {
    width: 100%;
    height: 100%;

    object-fit: cover;
    object-position: center;

    display: block;

    filter:
        grayscale(.25)
        brightness(.8);
}

.trash-no-image {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #718096;

    font-size: 10px;
    font-weight: 800;

    letter-spacing: 2px;
}

.trash-badge {
    position: absolute;

    top: 16px;
    right: 16px;

    padding: 7px 10px;

    border:
        1px solid rgba(
            255,
            125,
            143,
            .25
        );

    border-radius: 999px;

    background:
        rgba(
            10,
            13,
            20,
            .75
        );

    backdrop-filter:
        blur(10px);

    color: #ff7d8f;

    font-size: 8px;
    font-weight: 900;

    letter-spacing: 1.5px;
}


/* CONTENT */

.trash-content {
    padding: 22px;
}

.trash-product-meta {
    display: flex;
    justify-content: space-between;

    gap: 15px;

    margin-bottom: 12px;

    color: #718096;

    font-size: 8px;
    font-weight: 800;

    letter-spacing: 1.5px;
}

.trash-content h2 {
    margin: 0 0 22px;

    font-size: 20px;
    letter-spacing: -.5px;
}


/* DETAILS */

.trash-details {
    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 15px;

    margin-bottom: 18px;
}

.trash-details > div {
    padding: 13px;

    border: 1px solid var(--border);

    border-radius: 12px;

    background:
        rgba(255,255,255,.015);
}

.trash-details span,
.trash-deleted-date span {
    display: block;

    margin-bottom: 6px;

    color: #718096;

    font-size: 7px;
    font-weight: 800;

    letter-spacing: 1.5px;
}

.trash-details strong {
    font-size: 12px;
}


/* DELETED DATE */

.trash-deleted-date {
    margin-bottom: 22px;

    padding-bottom: 18px;

    border-bottom:
        1px solid var(--border);
}

.trash-deleted-date strong {
    font-size: 11px;
}


/* ACTIONS */

.trash-actions {
    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 10px;
}

.trash-actions form {
    width: 100%;
}

.restore-button,
.permanent-delete-button {
    width: 100%;
    min-height: 42px;

    padding: 0 12px;

    border-radius: 11px;

    cursor: pointer;

    font-family: inherit;

    font-size: 10px;
    font-weight: 800;

    transition: .2s ease;
}


/* RESTORE */

.restore-button {
    border:
        1px solid rgba(
            98,
            240,
            176,
            .22
        );

    background:
        rgba(
            98,
            240,
            176,
            .06
        );

    color: #62f0b0;
}

.restore-button span {
    margin-right: 5px;
}

.restore-button:hover {
    background:
        rgba(
            98,
            240,
            176,
            .12
        );

    transform:
        translateY(-1px);
}


/* DELETE */

.permanent-delete-button {
    border:
        1px solid rgba(
            255,
            125,
            143,
            .22
        );

    background:
        rgba(
            255,
            125,
            143,
            .05
        );

    color: #ff7d8f;
}

.permanent-delete-button:hover {
    background:
        rgba(
            255,
            125,
            143,
            .11
        );

    transform:
        translateY(-1px);
}


/* EMPTY */

.trash-empty {
    min-height: 420px;

    display: flex;
    flex-direction: column;

    align-items: center;
    justify-content: center;

    text-align: center;

    padding: 50px 25px;

    border: 1px solid var(--border);

    border-radius: 28px;

    background:
        radial-gradient(
            circle at 50% 40%,
            rgba(98,240,176,.07),
            transparent 35%
        );
}

.trash-empty-icon {
    width: 65px;
    height: 65px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 20px;

    border-radius: 50%;

    border:
        1px solid rgba(
            98,
            240,
            176,
            .2
        );

    color: #62f0b0;

    font-size: 25px;
}

.trash-empty > span {
    color: #62f0b0;

    font-size: 8px;
    font-weight: 800;

    letter-spacing: 2px;
}

.trash-empty h2 {
    margin: 10px 0;

    font-size: 32px;
}

.trash-empty p {
    margin: 0 0 25px;

    color: var(--muted);

    font-size: 13px;
}


/* RESPONSIVE */

@media (max-width: 1050px) {

    .trash-grid {
        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );
    }
}

@media (max-width: 700px) {

    .trash-page {
        padding-top: 45px;
    }

    .trash-header {
        flex-direction: column;

        align-items: flex-start;
    }

    .trash-header h1 {
        letter-spacing: -2px;
    }

    .trash-grid {
        grid-template-columns: 1fr;
    }

    .trash-header-actions,
    .trash-back-button {
        width: 100%;
    }
}

@media (max-width: 430px) {

    .trash-actions {
        grid-template-columns: 1fr;
    }
}

</style>

@endsection