@extends('layouts.app')

@section('title', 'Edit Product — RIJILL X MARKET')

@section('content')

<section class="product-form-page">

    <div class="container">

        {{-- HEADER --}}
        <div class="product-form-header reveal">

            <div>

                <span class="eyebrow">
                    RIJILL X MARKET / ADMIN / INVENTORY / EDIT
                </span>

                <h1>
                    Edit
                    <span class="gradient-text">
                        product.
                    </span>
                </h1>

                <p>
                    Perbarui informasi, harga, stok, kategori,
                    atau visual produk RIJILL X MARKET.
                </p>

            </div>

            <a
                href="{{ route('admin.products.index') }}"
                class="btn btn-secondary"
            >
                ← Back to Inventory
            </a>

        </div>


        <div class="product-form-layout">

            {{-- =========================================
                 FORM PANEL
            ========================================== --}}

            <div class="product-form-panel reveal">

                <div class="product-form-panel-head">

                    <div class="product-form-number">
                        {{ str_pad(
                            $product->id,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) }}
                    </div>

                    <div>

                        <span>
                            PRODUCT DATA / EDIT MODE
                        </span>

                        <h2>
                            Product information
                        </h2>

                    </div>

                </div>


                {{-- VALIDATION ERRORS --}}
                @if ($errors->any())

                    <div class="product-form-errors">

                        <strong>
                            Please check the product information.
                        </strong>

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    action="{{ route(
                        'admin.products.update',
                        $product
                    ) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="product-admin-form"
                >

                    @csrf
                    @method('PUT')


                    {{-- PRODUCT NAME --}}
                    <div class="product-admin-field">

                        <label for="name">
                            PRODUCT NAME
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old(
                                'name',
                                $product->name
                            ) }}"
                            placeholder="Product name"
                            required
                        >

                    </div>


                    {{-- CATEGORY --}}
                    <div class="product-admin-field">

                        <label for="category_id">
                            CATEGORY
                        </label>

                        <select
                            id="category_id"
                            name="category_id"
                            required
                        >

                            <option value="">
                                Select product category
                            </option>

                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old(
                                        'category_id',
                                        $product->category_id
                                    ) == $category->id
                                        ? 'selected'
                                        : ''
                                    }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- DESCRIPTION --}}
                    <div class="product-admin-field">

                        <label for="description">
                            PRODUCT DESCRIPTION
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            placeholder="Describe the product..."
                        >{{ old(
                            'description',
                            $product->description
                        ) }}</textarea>

                    </div>


                    {{-- PRICE + STOCK --}}
                    <div class="product-admin-grid">

                        <div class="product-admin-field">

                            <label for="price">
                                PRICE / IDR
                            </label>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                value="{{ old(
                                    'price',
                                    $product->price
                                ) }}"
                                min="0"
                                step="1"
                                required
                            >

                        </div>


                        <div class="product-admin-field">

                            <label for="stock">
                                STOCK / UNIT
                            </label>

                            <input
                                type="number"
                                id="stock"
                                name="stock"
                                value="{{ old(
                                    'stock',
                                    $product->stock
                                ) }}"
                                min="0"
                                step="1"
                                required
                            >

                        </div>

                    </div>


                    {{-- PRODUCT IMAGE --}}
                    <div class="product-admin-field">

                        <label for="image">
                            PRODUCT VISUAL
                        </label>


                        <label
                            for="image"
                            class="product-upload-zone"
                        >

                            {{-- CURRENT/PREVIEW IMAGE --}}
                            <img
                                id="productImagePreview"
                                class="product-image-preview"
                                src="{{ $product->image
                                    ? asset(
                                        'storage/' .
                                        $product->image
                                    )
                                    : ''
                                }}"
                                alt="{{ $product->name }}"
                                @if ($product->image)
                                    style="display: block;"
                                @endif
                            >


                            {{-- UPLOAD CONTENT --}}
                            <div
                                id="productUploadContent"
                                class="product-upload-content"
                                @if ($product->image)
                                    style="display: none;"
                                @endif
                            >

                                <div class="product-upload-icon">
                                    +
                                </div>


                                <div class="product-upload-text">

                                    <strong>
                                        Upload new product image
                                    </strong>

                                    <span>
                                        JPG, PNG, WEBP — maximum 2MB
                                    </span>

                                </div>


                                <span class="product-upload-action">
                                    BROWSE
                                </span>

                            </div>

                        </label>


                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/*"
                            class="product-file-input"
                        >


                        @if ($product->image)

                            <div
                                style="
                                    margin-top: 9px;
                                    color: #596576;
                                    font-size: 8px;
                                    line-height: 1.6;
                                "
                            >
                                Klik gambar di atas jika ingin
                                mengganti visual produk.
                                Jika tidak memilih gambar baru,
                                gambar lama tetap digunakan.
                            </div>

                        @endif

                    </div>


                    {{-- SAVE --}}
                    <div class="product-form-submit-area">

                        <div class="product-form-note">

                            <span>◇</span>

                            <p>
                                Perubahan akan langsung diterapkan
                                pada katalog RIJILL X MARKET.
                            </p>

                        </div>


                        <button
                            type="submit"
                            class="product-save-button"
                        >

                            <span>
                                Save Changes
                            </span>

                            <span class="product-save-arrow">
                                →
                            </span>

                        </button>

                    </div>

                </form>

            </div>


            {{-- =========================================
                 SIDE PANEL
            ========================================== --}}

            <aside class="product-form-side reveal">

                <div class="product-side-status">

                    <span></span>

                    EDIT MODE ACTIVE

                </div>


                <span class="product-side-code">
                    RXM /
                    {{ str_pad(
                        $product->id,
                        3,
                        '0',
                        STR_PAD_LEFT
                    ) }}
                </span>


                <h2>
                    Refine the
                    <span class="gradient-text">
                        product.
                    </span>
                </h2>


                <p>
                    Kamu sedang mengubah data
                    <strong>{{ $product->name }}</strong>.
                    Pastikan informasi produk sudah benar
                    sebelum menyimpan perubahan.
                </p>


                <div class="product-side-line"></div>


                <div class="product-side-info">

                    <div>

                        <span>01</span>

                        <div>
                            <strong>Identity</strong>
                            <small>
                                {{ $product->name }}
                            </small>
                        </div>

                    </div>


                    <div>

                        <span>02</span>

                        <div>
                            <strong>Inventory</strong>

                            <small>
                                {{ $product->stock }}
                                units available
                            </small>
                        </div>

                    </div>


                    <div>

                        <span>03</span>

                        <div>
                            <strong>Current Price</strong>

                            <small>
                                IDR
                                {{ number_format(
                                    $product->price,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </small>
                        </div>

                    </div>

                </div>


                <div class="product-side-footer">

                    <span>
                        RIJILL X MARKET
                    </span>

                    <span>
                        EDIT SYSTEM
                    </span>

                </div>

            </aside>

        </div>

    </div>

</section>

@endsection