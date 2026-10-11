<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $cart = [];

        foreach ($cartItems as $cartItem) {

            /*
             * Jika produk sudah tidak tersedia
             * atau sudah masuk Trash, hapus item
             * tersebut dari cart.
             */
            if (!$cartItem->product) {
                $cartItem->delete();
                continue;
            }

            $product = $cartItem->product;

            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $cartItem->quantity,
                'image' => $product->image,
                'stock' => $product->stock,
            ];
        }

        return view(
            'cart.index',
            compact('cart')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */

    public function add(Product $product)
    {
        /*
         * Produk dengan stok 0 tidak
         * boleh dimasukkan ke cart.
         */
        if ($product->stock < 1) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Produk sedang kehabisan stok.'
                );
        }


        $cartItem = Cart::where(
            'user_id',
            Auth::id()
        )
            ->where(
                'product_id',
                $product->id
            )
            ->first();


        /*
         * Produk sudah ada di cart.
         */
        if ($cartItem) {

            if (
                $cartItem->quantity >=
                $product->stock
            ) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Jumlah produk di keranjang ' .
                        'sudah mencapai stok tersedia.'
                    );
            }


            $cartItem->increment(
                'quantity'
            );

        } else {

            /*
             * Produk belum ada di cart.
             */
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }


        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan ' .
                'ke keranjang.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE QUANTITY
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);


        /*
         * Hanya cart milik user login
         * yang dapat diubah.
         */
        $cartItem = Cart::with('product')
            ->where(
                'user_id',
                Auth::id()
            )
            ->where(
                'product_id',
                $id
            )
            ->firstOrFail();


        /*
         * Produk mungkin sudah dipindahkan
         * admin ke Trash.
         */
        if (!$cartItem->product) {

            $cartItem->delete();

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Produk sudah tidak tersedia.'
                );
        }


        /*
         * Quantity tidak boleh
         * melebihi stok.
         */
        if (
            $validated['quantity'] >
            $cartItem->product->stock
        ) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Jumlah melebihi stok yang tersedia.'
                );
        }


        $cartItem->update([
            'quantity' =>
                $validated['quantity'],
        ]);


        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Jumlah produk berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE FROM CART
    |--------------------------------------------------------------------------
    */

    public function remove($id)
    {
        /*
         * Tetap dibatasi user_id,
         * sehingga user tidak dapat
         * menghapus cart user lain.
         */
        Cart::where(
            'user_id',
            Auth::id()
        )
            ->where(
                'product_id',
                $id
            )
            ->delete();


        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Produk berhasil dihapus dari keranjang.'
            );
    }
}