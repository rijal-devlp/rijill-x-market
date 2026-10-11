<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom snapshot gambar produk
     * ke setiap item pesanan.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('product_image')
                ->nullable()
                ->after('product_name');
        });
    }

    /**
     * Hapus kolom jika migration di-rollback.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('product_image');
        });
    }
};