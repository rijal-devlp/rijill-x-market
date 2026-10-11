@extends('layouts.app')

@section('title', 'Your Cart — RIJILL X MARKET')

@section('content')

<section class="cart-page">

    <div class="container">

        {{-- HEADER --}}
        <div class="cart-header reveal">

            <div>
                <span class="eyebrow">
                    RIJILL X MARKET / CART
                </span>

                <h1>
                    Your
                    <span class="gradient-text">selection.</span>
                </h1>
            </div>

            <a
                href="{{ route('products.index') }}"
                class="continue-shopping"
            >
                ← Continue Exploring
            </a>

        </div>


        @if (count($cart) > 0)

            @php
                $total = 0;
                $totalItems = 0;
            @endphp
            <form
    id="selected-checkout-form"
    action="{{ route('checkout.select') }}"
    method="POST"
>
    @csrf
</form>

            <div class="cart-layout">

                {{-- =========================
                     CART ITEMS
                ========================== --}}

                <div class="cart-items">
                    <div class="cart-select-all">
    <label class="select-all-label">
        <input
            type="checkbox"
            id="select-all-cart"
            checked
        >

        <span class="select-all-checkmark"></span>

        <span>
            Select All
        </span>
    </label>
</div>

                    @foreach ($cart as $id => $item)

                        @php
                            $subtotal =
                                $item['price'] *
                                $item['quantity'];

                            $total += $subtotal;

                            $totalItems +=
                                $item['quantity'];
                        @endphp


                        <article class="cart-item reveal">
                            <label class="cart-select">
    <input
        type="checkbox"
        name="selected_items[]"
        value="{{ $id }}"
        form="selected-checkout-form"
        class="cart-checkbox"
        data-price="{{ $item['price'] }}"
        data-quantity="{{ $item['quantity'] }}"
        checked
    >

    <span class="cart-checkmark"></span>
</label>

                            {{-- IMAGE --}}
                            <div class="cart-item-image">

                                @if ($item['image'])

                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            $item['image']
                                        ) }}"
                                        alt="{{ $item['name'] }}"
                                    >

                                @else

                                    <div class="cart-no-image">
                                        RJL
                                    </div>

                                @endif

                                <span class="cart-product-code">
                                    RJL /
                                    {{ str_pad(
                                        $id,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </span>

                            </div>


                            {{-- INFO --}}
                            <div class="cart-item-content">

                                <div class="cart-item-top">

                                    <div>

                                        <span class="cart-item-label">
                                            SELECTED PRODUCT
                                        </span>

                                        <h2>
                                            {{ $item['name'] }}
                                        </h2>

                                    </div>


                                    <form
                                        action="{{ route(
                                            'cart.remove',
                                            $id
                                        ) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="cart-remove"
                                            aria-label="Hapus produk"
                                        >
                                            ×
                                        </button>

                                    </form>

                                </div>


                                <div class="cart-unit-price">

                                    <span>UNIT PRICE</span>

                                    <strong>
                                        IDR
                                        {{ number_format(
                                            $item['price'],
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </strong>

                                </div>


                                <div class="cart-item-bottom">

                                    {{-- QUANTITY --}}
                                    <form
                                        action="{{ route(
                                            'cart.update',
                                            $id
                                        ) }}"
                                        method="POST"
                                        class="quantity-form"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <label>
                                            QTY
                                        </label>

                                        <div class="quantity-control">

                                            <button
                                                type="button"
                                                class="quantity-button quantity-minus"
                                            >
                                                −
                                            </button>

                                            <input
                                                type="number"
                                                name="quantity"
                                                value="{{ $item['quantity'] }}"
                                                min="1"
                                                class="quantity-input"
                                            >

                                            <button
                                                type="button"
                                                class="quantity-button quantity-plus"
                                            >
                                                +
                                            </button>

                                        </div>

                                        <button
                                            type="submit"
                                            class="update-cart-button"
                                        >
                                            Update
                                        </button>

                                    </form>


                                    {{-- SUBTOTAL --}}
                                    <div class="cart-subtotal">

                                        <span>
                                            SUBTOTAL
                                        </span>

                                        <strong>
                                            IDR
                                            {{ number_format(
                                                $subtotal,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- =========================
                     ORDER SUMMARY
                ========================== --}}

                <aside class="cart-summary reveal">

                    <div class="summary-status">

                        <span class="summary-status-dot"></span>

                        CART ACTIVE

                    </div>


                    <h2>
                        Order
                        <span class="gradient-text">
                            summary.
                        </span>
                    </h2>


                    <div class="summary-divider"></div>


                    <div class="summary-row">

                        <span>
                            Products
                        </span>

                        <strong>
                            <span id="selected-item-count">
    {{ $totalItems }}
</span> item
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Subtotal
                        </span>

                        <strong>
    IDR
    <span id="selected-subtotal">
        {{ number_format(
            $total,
            0,
            ',',
            '.'
        ) }}
    </span>
</strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Delivery
                        </span>

                        <strong class="summary-calculated">
                            Calculated later
                        </strong>

                    </div>


                    <div class="summary-divider"></div>


                    <div class="summary-total">

                        <div>
                            <span>
                                TOTAL
                            </span>

                            <small>
                                Current order value
                            </small>
                        </div>

                        <strong>
    IDR
    <span id="selected-total">
        {{ number_format(
            $total,
            0,
            ',',
            '.'
        ) }}
    </span>
</strong>

                    </div>


                    <button
    type="submit"
    form="selected-checkout-form"
    class="checkout-button"
    id="selected-checkout-button"
>
    <span>
        Continue to Checkout
    </span>

    <span class="checkout-arrow">
        →
    </span>
</button>

                        <span>
                            Continue to Checkout
                        </span>

                        <span class="checkout-arrow">
                            →
                        </span>

                    </a>


                    <div class="summary-security">

                        <span>◆</span>

                        <p>
                            Your order information is processed
                            securely by RIJILL X MARKET.
                        </p>

                    </div>

                </aside>

            </div>


        @else

            {{-- =========================
                 EMPTY CART
            ========================== --}}

            <div class="empty-cart reveal">

                <div class="empty-cart-orbit">

                    <div class="empty-orbit-ring"></div>

                    <span>
                        RJL
                    </span>

                </div>


                <span class="empty-cart-code">
                    RJL / EMPTY CART
                </span>

                <h2>
                    Your cart is
                    <span class="gradient-text">
                        waiting.
                    </span>
                </h2>

                <p>
                    Belum ada produk dalam keranjang.
                    Jelajahi koleksi RIJILL X MARKET dan
                    temukan pilihanmu.
                </p>

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-primary"
                >
                    Explore Collection →
                </a>

            </div>

        @endif

    </div>

</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('select-all-cart');
    const checkboxes = document.querySelectorAll('.cart-checkbox');

    const checkoutButton = document.getElementById(
        'selected-checkout-button'
    );

    const itemCount = document.getElementById(
        'selected-item-count'
    );

    const subtotalElement = document.getElementById(
        'selected-subtotal'
    );

    const totalElement = document.getElementById(
        'selected-total'
    );

    if (!selectAll || checkboxes.length === 0) {
        return;
    }

    const storageKey = 'rijill_cart_selection';

    function getSavedSelection() {
        try {
            const saved = sessionStorage.getItem(storageKey);

            if (saved === null) {
                return null;
            }

            return JSON.parse(saved);
        } catch (error) {
            return null;
        }
    }

    function saveSelection() {
        const selectedIds = [];

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                selectedIds.push(checkbox.value);
            }
        });

        sessionStorage.setItem(
            storageKey,
            JSON.stringify(selectedIds)
        );
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function updateSelection(save = true) {
        const checked = document.querySelectorAll(
            '.cart-checkbox:checked'
        );

        let totalItems = 0;
        let totalPrice = 0;

        checked.forEach(function (checkbox) {
            const price = Number(
                checkbox.dataset.price
            );

            const quantity = Number(
                checkbox.dataset.quantity
            );

            totalItems += quantity;
            totalPrice += price * quantity;
        });

        if (itemCount) {
            itemCount.textContent = totalItems;
        }

        if (subtotalElement) {
            subtotalElement.textContent =
                formatRupiah(totalPrice);
        }

        if (totalElement) {
            totalElement.textContent =
                formatRupiah(totalPrice);
        }

        selectAll.checked =
            checked.length === checkboxes.length;

        selectAll.indeterminate =
            checked.length > 0 &&
            checked.length < checkboxes.length;

        if (checkoutButton) {
            checkoutButton.disabled =
                checked.length === 0;
        }

        if (save) {
            saveSelection();
        }
    }

    // Ambil pilihan terakhir saat halaman dibuka
    const savedSelection = getSavedSelection();

    if (savedSelection !== null) {
        checkboxes.forEach(function (checkbox) {
            checkbox.checked =
                savedSelection.includes(checkbox.value);
        });
    }

    // Select All
    selectAll.addEventListener('change', function () {
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = selectAll.checked;
        });

        updateSelection();
    });

    // Checkbox masing-masing produk
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            updateSelection();
        });
    });

    updateSelection(false);
});
</script>

@endsection