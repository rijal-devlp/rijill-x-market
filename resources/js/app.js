import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | Mobile Navigation
    |--------------------------------------------------------------------------
    */

    const menuButton = document.getElementById('menuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Reveal Animation
    |--------------------------------------------------------------------------
    */

    const revealElements =
        document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window) {

        const observer = new IntersectionObserver(
            (entries) => {

                entries.forEach((entry) => {

                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }

                });

            },
            {
                threshold: 0.10,
            }
        );

        revealElements.forEach((element) => {
            observer.observe(element);
        });

    } else {

        revealElements.forEach((element) => {
            element.classList.add('visible');
        });

    }


    /*
    |--------------------------------------------------------------------------
    | Product Search + Category Filter
    |--------------------------------------------------------------------------
    */

    const searchInput =
        document.getElementById('productSearch');

    const productCards =
        document.querySelectorAll('.product-card');

    const noResults =
        document.getElementById('noResults');

    const categoryButtons =
        document.querySelectorAll('.category-filter-btn');

    let activeCategory = 'all';


    /*
     * Menampilkan produk berdasarkan:
     * 1. Search
     * 2. Kategori aktif
     */

    const filterProducts = () => {

        const keyword =
            searchInput
                ? searchInput.value.toLowerCase().trim()
                : '';

        let visibleProducts = 0;


        productCards.forEach((card) => {

            const productName =
                (card.dataset.productName || '')
                    .toLowerCase();

            const category =
                (card.dataset.category || '')
                    .toLowerCase();


            /*
             * Cocok dengan pencarian
             */

            const matchesSearch =
                productName.includes(keyword) ||
                category.includes(keyword);


            /*
             * Cocok dengan kategori
             */

            const matchesCategory =
                activeCategory === 'all' ||
                category === activeCategory;


            /*
             * Produk harus memenuhi keduanya
             */

            const shouldShow =
                matchesSearch &&
                matchesCategory;


            if (shouldShow) {

                card.style.display = '';
                visibleProducts++;

            } else {

                card.style.display = 'none';

            }

        });


        /*
         * Tampilkan pesan jika tidak ada produk
         */

        if (noResults) {

            noResults.style.display =
                visibleProducts === 0
                    ? 'block'
                    : 'none';

        }

    };


    /*
     * Search Produk
     */

    if (searchInput && productCards.length > 0) {

        searchInput.addEventListener(
            'input',
            filterProducts
        );

    }


    /*
     * Filter Kategori
     */

    categoryButtons.forEach((button) => {

        button.addEventListener('click', () => {

            /*
             * Ambil kategori dari tombol
             */

            activeCategory =
                (
                    button.dataset.categoryFilter ||
                    'all'
                ).toLowerCase();


            /*
             * Hilangkan status active
             * dari semua tombol
             */

            categoryButtons.forEach((item) => {
                item.classList.remove('active');
            });


            /*
             * Aktifkan tombol yang diklik
             */

            button.classList.add('active');


            /*
             * Filter ulang produk
             */

            filterProducts();

        });

    });


    /*
     * Jalankan filter pertama kali
     */

    if (productCards.length > 0) {
        filterProducts();
    }


    /*
    |--------------------------------------------------------------------------
    | Cart Quantity Buttons
    |--------------------------------------------------------------------------
    */

    const minusButtons =
        document.querySelectorAll('.quantity-minus');

    const plusButtons =
        document.querySelectorAll('.quantity-plus');

    minusButtons.forEach((button) => {

        button.addEventListener('click', () => {

            const control =
                button.closest('.quantity-control');

            if (!control) {
                return;
            }

            const input =
                control.querySelector('.quantity-input');

            if (!input) {
                return;
            }

            const currentValue =
                parseInt(input.value, 10) || 1;

            if (currentValue > 1) {
                input.value = currentValue - 1;
            }

        });

    });

    plusButtons.forEach((button) => {

        button.addEventListener('click', () => {

            const control =
                button.closest('.quantity-control');

            if (!control) {
                return;
            }

            const input =
                control.querySelector('.quantity-input');

            if (!input) {
                return;
            }

            const currentValue =
                parseInt(input.value, 10) || 1;

            input.value = currentValue + 1;

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Password Visibility
    |--------------------------------------------------------------------------
    */

    const passwordToggles =
        document.querySelectorAll('[data-password-toggle]');

    passwordToggles.forEach((button) => {

        button.addEventListener('click', () => {

            const inputId =
                button.dataset.passwordToggle;

            const input =
                document.getElementById(inputId);

            if (!input) {
                return;
            }

            const isPassword =
                input.type === 'password';

            input.type =
                isPassword
                    ? 'text'
                    : 'password';

            button.textContent =
                isPassword
                    ? 'HIDE'
                    : 'SHOW';

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Product Image Preview
    |--------------------------------------------------------------------------
    */

    const productImageInput =
        document.getElementById('image');

    const productImagePreview =
        document.getElementById('productImagePreview');

    const productUploadContent =
        document.getElementById('productUploadContent');

    if (
        productImageInput &&
        productImagePreview &&
        productUploadContent
    ) {

        productImageInput.addEventListener('change', () => {

            const file =
                productImageInput.files[0];

            if (!file) {

                productImagePreview.src = '';

                productImagePreview.style.display =
                    'none';

                productUploadContent.style.display =
                    '';

                return;
            }


            /*
             * Pastikan file adalah gambar
             */

            if (!file.type.startsWith('image/')) {

                productImageInput.value = '';

                productImagePreview.src = '';

                productImagePreview.style.display =
                    'none';

                productUploadContent.style.display =
                    '';

                alert('File yang dipilih harus berupa gambar.');

                return;
            }


            /*
             * Maksimum 2 MB
             */

            const maximumSize =
                2 * 1024 * 1024;

            if (file.size > maximumSize) {

                productImageInput.value = '';

                productImagePreview.src = '';

                productImagePreview.style.display =
                    'none';

                productUploadContent.style.display =
                    '';

                alert('Ukuran gambar maksimal 2MB.');

                return;
            }


            /*
             * Buat preview gambar
             */

            const reader =
                new FileReader();

            reader.addEventListener('load', (event) => {

                productImagePreview.src =
                    event.target.result;

                productImagePreview.style.display =
                    'block';

                productUploadContent.style.display =
                    'none';

            });

            reader.readAsDataURL(file);

        });

    }

});