<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SELECT CHECKOUT ITEMS
    |--------------------------------------------------------------------------
    */

    public function select(Request $request)
    {
        $validated = $request->validate([
            'selected_items' => [
                'required',
                'array',
                'min:1',
            ],

            'selected_items.*' => [
                'integer',
                'distinct',
            ],
        ]);

        $selectedIds = Cart::where(
            'user_id',
            Auth::id()
        )
            ->whereIn(
                'product_id',
                $validated['selected_items']
            )
            ->pluck('product_id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        if (empty($selectedIds)) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Pilih minimal satu produk untuk checkout.'
                );
        }

        session([
            'checkout_selected_items' => $selectedIds,
        ]);

        return redirect()
            ->route('checkout.index');
    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $selectedIds = session(
            'checkout_selected_items',
            []
        );

        if (empty($selectedIds)) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Pilih produk yang ingin di-checkout.'
                );
        }

        $cartItems = Cart::with('product')
            ->where(
                'user_id',
                Auth::id()
            )
            ->whereIn(
                'product_id',
                $selectedIds
            )
            ->get();

        if ($cartItems->isEmpty()) {
            session()->forget(
                'checkout_selected_items'
            );

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Produk yang dipilih tidak ditemukan.'
                );
        }

        $cart = [];
        $total = 0;

        foreach ($cartItems as $cartItem) {

            if (!$cartItem->product) {
                continue;
            }

            $product = $cartItem->product;

            if (
                $product->stock <
                $cartItem->quantity
            ) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Stok produk ' .
                        $product->name .
                        ' tidak mencukupi.'
                    );
            }

            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $cartItem->quantity,
                'image' => $product->image,
                'stock' => $product->stock,
            ];

            $total +=
                $product->price *
                $cartItem->quantity;
        }

        if (empty($cart)) {
            session()->forget(
                'checkout_selected_items'
            );

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Produk yang dipilih sudah tidak tersedia.'
                );
        }

        return view(
            'checkout.index',
            compact('cart', 'total')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE ORDER
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'address' => [
                'required',
                'string',
                'max:1000',
            ],

            /*
             * Metode pembayaran hanya boleh
             * menggunakan pilihan yang kita sediakan.
             */
            'payment_method' => [
                'required',
                'string',
                'in:qris,bank_transfer,ewallet,cod',
            ],
        ]);

        $selectedIds = session(
            'checkout_selected_items',
            []
        );

        if (empty($selectedIds)) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Pilih produk yang ingin di-checkout.'
                );
        }

        /*
         * Menyimpan daftar file snapshot yang dibuat.
         *
         * Jika database transaction gagal,
         * file-file ini akan ikut dibersihkan.
         */
        $createdSnapshots = [];

        try {

            $order = DB::transaction(
                function () use (
                    $validated,
                    $selectedIds,
                    &$createdSnapshots
                ) {

                    $cartItems = Cart::where(
                        'user_id',
                        Auth::id()
                    )
                        ->whereIn(
                            'product_id',
                            $selectedIds
                        )
                        ->get();

                    if ($cartItems->isEmpty()) {
                        throw ValidationException::withMessages([
                            'cart' =>
                                'Produk checkout tidak ditemukan.',
                        ]);
                    }

                    $items = [];
                    $total = 0;

                    foreach ($cartItems as $cartItem) {

                        /*
                         * Lock product selama transaction.
                         */
                        $product = Product::where(
                            'id',
                            $cartItem->product_id
                        )
                            ->lockForUpdate()
                            ->first();

                        if (!$product) {
                            throw ValidationException::withMessages([
                                'cart' =>
                                    'Salah satu produk sudah tidak tersedia.',
                            ]);
                        }

                        if ($cartItem->quantity < 1) {
                            throw ValidationException::withMessages([
                                'cart' =>
                                    'Jumlah produk tidak valid.',
                            ]);
                        }

                        if (
                            $product->stock <
                            $cartItem->quantity
                        ) {
                            throw ValidationException::withMessages([
                                'cart' =>
                                    'Stok produk ' .
                                    $product->name .
                                    ' tidak mencukupi.',
                            ]);
                        }

                        $subtotal =
                            $product->price *
                            $cartItem->quantity;

                        $total += $subtotal;

                        $items[] = [
                            'product' => $product,
                            'quantity' =>
                                $cartItem->quantity,
                            'subtotal' => $subtotal,
                        ];
                    }

                    /*
                     * Buat order utama.
                     */
                    $order = Order::create([
                        'user_id' => Auth::id(),

                        'customer_name' =>
                            $validated['customer_name'],

                        'email' =>
                            $validated['email'],

                        'phone' =>
                            $validated['phone'],

                        'address' =>
                            $validated['address'],

                        /*
                         * Simpan metode pembayaran
                         * yang dipilih customer.
                         */
                        'payment_method' =>
                            $validated['payment_method'],

                        /*
                         * Karena ini sistem pembayaran
                         * simulasi, order baru selalu
                         * dimulai sebagai unpaid.
                         */
                        'payment_status' => 'unpaid',

                        'total_price' => $total,

                        'status' => 'pending',
                    ]);


                    foreach ($items as $item) {

                        $product =
                            $item['product'];

                        /*
                         * Buat snapshot gambar khusus
                         * untuk histori order.
                         */
                        $snapshotPath = null;

                        if (
                            $product->image &&
                            Storage::disk('public')
                                ->exists($product->image)
                        ) {
                            $extension =
                                pathinfo(
                                    $product->image,
                                    PATHINFO_EXTENSION
                                );

                            $fileName =
                                'order-' .
                                $order->id .
                                '-product-' .
                                $product->id .
                                '-' .
                                Str::uuid() .
                                (
                                    $extension
                                        ? '.' . $extension
                                        : ''
                                );

                            $snapshotPath =
                                'order-items/' .
                                $fileName;

                            $copied =
                                Storage::disk('public')
                                    ->copy(
                                        $product->image,
                                        $snapshotPath
                                    );

                            if (!$copied) {
                                throw new \RuntimeException(
                                    'Gagal membuat snapshot gambar produk.'
                                );
                            }

                            $createdSnapshots[] =
                                $snapshotPath;
                        }


                        /*
                         * Simpan snapshot informasi produk.
                         */
                        OrderItem::create([
                            'order_id' => $order->id,

                            'product_id' =>
                                $product->id,

                            'product_name' =>
                                $product->name,

                            'product_image' =>
                                $snapshotPath,

                            'price' =>
                                $product->price,

                            'quantity' =>
                                $item['quantity'],

                            'subtotal' =>
                                $item['subtotal'],
                        ]);


                        /*
                         * Kurangi stok.
                         */
                        $product->decrement(
                            'stock',
                            $item['quantity']
                        );
                    }


                    /*
                     * Hapus hanya item cart
                     * yang berhasil di-checkout.
                     */
                    Cart::where(
                        'user_id',
                        Auth::id()
                    )
                        ->whereIn(
                            'product_id',
                            $selectedIds
                        )
                        ->delete();


                    return $order;
                }
            );


            /*
             * Transaction sukses.
             */
            session()->forget(
                'checkout_selected_items'
            );


            return redirect()
                ->route(
                    'checkout.success',
                    $order
                );

        } catch (ValidationException $e) {

            /*
             * Database transaction dapat rollback,
             * tetapi file storage bukan bagian dari
             * database transaction.
             *
             * Jadi snapshot yang sempat dibuat
             * harus kita hapus manual.
             */
            foreach ($createdSnapshots as $snapshot) {
                Storage::disk('public')
                    ->delete($snapshot);
            }

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    collect($e->errors())
                        ->flatten()
                        ->first()
                );

        } catch (\Throwable $e) {

            /*
             * Bersihkan snapshot jika proses gagal.
             */
            foreach ($createdSnapshots as $snapshot) {
                Storage::disk('public')
                    ->delete($snapshot);
            }

            report($e);

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Checkout gagal. Silakan coba lagi.'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT SUCCESS
    |--------------------------------------------------------------------------
    */

    public function success(Order $order)
    {
        if (
            (int) $order->user_id !==
            (int) Auth::id()
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke pesanan ini.'
            );
        }

        $order->load('items');

        return view(
            'checkout.success',
            compact('order')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MY ORDERS
    |--------------------------------------------------------------------------
    */

    public function myOrders()
    {
        $orders = Order::where(
            'user_id',
            Auth::id()
        )
            ->latest()
            ->get();

        return view(
            'orders.index',
            compact('orders')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ORDER DETAIL
    |--------------------------------------------------------------------------
    */

    public function showOrder(Order $order)
    {
        if (
            (int) $order->user_id !==
            (int) Auth::id()
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke pesanan ini.'
            );
        }

        $order->load('items');

        return view(
            'orders.show',
            compact('order')
        );
    }
}