<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PRODUCT LIST
    |--------------------------------------------------------------------------
    */

    // Menampilkan semua produk aktif
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->get();

        return view(
            'admin.products.index',
            compact('products')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::all();

        return view(
            'admin.products.create',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'category_id' =>
                'required|exists:categories,id',

            'description' =>
                'nullable|string',

            'price' =>
                'required|numeric|min:0',

            'stock' =>
                'required|integer|min:0',

            'image' =>
                'nullable|image|max:2048',
        ]);


        // Upload gambar jika ada
        if ($request->hasFile('image')) {

            $validated['image'] =
                $request
                    ->file('image')
                    ->store(
                        'products',
                        'public'
                    );
        }


        Product::create($validated);


        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT PRODUCT
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'category_id' =>
                'required|exists:categories,id',

            'description' =>
                'nullable|string',

            'price' =>
                'required|numeric|min:0',

            'stock' =>
                'required|integer|min:0',

            'image' =>
                'nullable|image|max:2048',
        ]);


        /*
        |--------------------------------------------------------------------------
        | REPLACE IMAGE
        |--------------------------------------------------------------------------
        |
        | Jika admin mengupload gambar baru:
        | - gambar lama dihapus dari storage
        | - gambar baru disimpan
        |
        */

        if ($request->hasFile('image')) {

            if (
                $product->image &&
                Storage::disk('public')
                    ->exists($product->image)
            ) {
                Storage::disk('public')
                    ->delete($product->image);
            }


            $validated['image'] =
                $request
                    ->file('image')
                    ->store(
                        'products',
                        'public'
                    );
        }


        $product->update($validated);


        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Produk berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SOFT DELETE PRODUCT
    |--------------------------------------------------------------------------
    |
    | Produk tidak benar-benar dihapus.
    | Produk hanya dipindahkan ke Trash.
    |
    */

    public function destroy(Product $product)
    {
        $product->delete();


        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Produk dipindahkan ke Trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TRASH
    |--------------------------------------------------------------------------
    */

    public function trash()
    {
        $products = Product::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->get();


        return view(
            'admin.products.trash',
            compact('products')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RESTORE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function restore($id)
    {
        $product = Product::onlyTrashed()
            ->findOrFail($id);


        $product->restore();


        return redirect()
            ->route('admin.products.trash')
            ->with(
                'success',
                'Produk berhasil dikembalikan ke Collection.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PERMANENT DELETE
    |--------------------------------------------------------------------------
    |
    | Produk benar-benar dihapus dari database.
    | File gambar juga dihapus dari storage.
    |
    */

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()
            ->findOrFail($id);


        /*
         * Hapus file gambar
         */
        if (
            $product->image &&
            Storage::disk('public')
                ->exists($product->image)
        ) {
            Storage::disk('public')
                ->delete($product->image);
        }


        /*
         * Hapus produk secara permanen
         */
        $product->forceDelete();


        return redirect()
            ->route('admin.products.trash')
            ->with(
                'success',
                'Produk berhasil dihapus permanen.'
            );
    }
}