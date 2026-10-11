@extends('layouts.app')

@section('title', 'Add Product — RIJILL X MARKET')

@section('content')

<section class="product-form-page">

    <div class="container">

        <div class="product-form-header reveal">

            <div>

                <span class="eyebrow">
                    RIJILL X MARKET / ADMIN / INVENTORY
                </span>

                <h1>
                    Create new
                    <span class="gradient-text">
                        product.
                    </span>
                </h1>

                <p>
                    Tambahkan produk baru ke katalog
                    RIJILL X MARKET. Lengkapi informasi
                    produk dan inventory.
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

            <div class="product-form-panel reveal">

                <div class="product-form-panel-head">

                    <div class="product-form-number">
                        01
                    </div>

                    <div>
                        <span>PRODUCT DATA</span>

                        <h2>
                            Product information
                        </h2>
                    </div>

                </div>


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
                    action="{{ route('admin.products.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="product-admin-form"
                >

                    @csrf


                    <div class="product-admin-field">

                        <label for="name">
                            PRODUCT NAME
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Example: Oversize Future Hoodie"
                            required
                        >

                    </div>


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
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="product-admin-field">

                        <label for="description">
                            PRODUCT DESCRIPTION
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            placeholder="Describe the product..."
                        >{{ old('description') }}</textarea>

                    </div>


                    <div class="product-admin-grid">

                        <div class="product-admin-field">

                            <label for="price">
                                PRICE / IDR
                            </label>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                value="{{ old('price') }}"
                                min="0"
                                step="1"
                                placeholder="150000"
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
                                value="{{ old('stock', 0) }}"
                                min="0"
                                step="1"
                                placeholder="10"
                                required
                            >

                        </div>

                    </div>


                    <div class="product-admin-field">

                        <label for="image">
                            PRODUCT VISUAL
                        </label>


                        <label
                            for="image"
                            class="product-upload-zone"
                        >

                            {{-- Preview gambar --}}
                            <img
                                id="productImagePreview"
                                class="product-image-preview"
                                src=""
                                alt="Product preview"
                            >


                            {{-- Tampilan sebelum gambar dipilih --}}
                            <div
                                id="productUploadContent"
                                class="product-upload-content"
                            >

                                <div class="product-upload-icon">
                                    +
                                </div>

                                <div class="product-upload-text">

                                    <strong>
                                        Upload product image
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

                    </div>


                    <div class="product-form-submit-area">

                        <div class="product-form-note">

                            <span>◇</span>

                            <p>
                                Produk akan langsung masuk
                                ke katalog setelah berhasil
                                disimpan.
                            </p>

                        </div>


                        <button
                            type="submit"
                            class="product-save-button"
                        >

                            <span>
                                Create Product
                            </span>

                            <span class="product-save-arrow">
                                →
                            </span>

                        </button>

                    </div>

                </form>

            </div>


            <aside class="product-form-side reveal">

                <div class="product-side-status">

                    <span></span>

                    INVENTORY READY

                </div>


                <span class="product-side-code">
                    RXM / PRODUCT CREATION
                </span>


                <h2>
                    Build the
                    <span class="gradient-text">
                        collection.
                    </span>
                </h2>


                <p>
                    Setiap produk yang dibuat akan tersedia
                    pada storefront RIJILL X MARKET.
                </p>


                <div class="product-side-line"></div>


                <div class="product-side-info">

                    <div>

                        <span>01</span>

                        <div>
                            <strong>Identity</strong>
                            <small>Name & category</small>
                        </div>

                    </div>


                    <div>

                        <span>02</span>

                        <div>
                            <strong>Commerce</strong>
                            <small>Price & inventory</small>
                        </div>

                    </div>


                    <div>

                        <span>03</span>

                        <div>
                            <strong>Visual</strong>
                            <small>Product imagery</small>
                        </div>

                    </div>

                </div>


                <div class="product-side-footer">

                    <span>
                        RIJILL X MARKET
                    </span>

                    <span>
                        ADMIN SYSTEM
                    </span>

                </div>

            </aside>

        </div>

    </div>

</section>

@endsection