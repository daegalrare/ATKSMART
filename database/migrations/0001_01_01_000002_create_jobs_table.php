<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('nama_barang')->nullable();
            $table->string('kode_barang')->nullable()->unique();
            $table->integer('stok_barang')->nullable();
            $table->decimal('harga_beli')->nullable();
            $table->decimal('harga_jual')->nullable();
            $table->timestamps();
        });
        Schema::create('account', function (Blueprint $table) {
            $table->increments('id_akun');
            $table->string('email_akun')->nullable()->unique();
            $table->string('nama_akun')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('role')->nullable();
            $table->string('password_hashed')->nullable();
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id_kategori');
            $table->string('nama_kategori')->nullable();
            $table->timestamps();
        });
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id_produk');
            $table->unsignedInteger('id_kategori')->nullable();
            $table->string('kode_produk')->nullable()->unique();
            $table->string('nama_produk')->nullable();
            $table->string('satuan_terkecil')->nullable();
            $table->string('satuan_besar')->nullable();
            $table->integer('isi_per_satuan_besar')->nullable();
            $table->string('lokasi_produk')->nullable();
            $table->integer('stok_minimum')->nullable();
            $table->integer('stok_produk')->nullable();
            $table->decimal('harga_jual', 15, 2)->nullable();
            $table->decimal('harga_beli_terakhir', 15, 2)->nullable();
            $table->timestamps();
            $table->foreign('id_kategori')->references('id_kategori')->on('categories')->onDelete('set null');
        });
        Schema::create('pembelian_stok', function (Blueprint $table) {
            $table->increments('id_pembelian');
            $table->unsignedInteger('id_produk')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->integer('jumlah_barang_masuk')->nullable();
            $table->decimal('harga_beli_satuan', 15, 2)->nullable();
            $table->decimal('total_harga_beli', 15, 2)->nullable();
            $table->timestamps();
            $table->foreign('id_produk')->references('id_produk')->on('product')->onDelete('set null');
        });
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('id_penjualan');
            $table->unsignedInteger('id_akun')->nullable();
            $table->string('no_invoice')->unique();
            $table->dateTime('tanggal_penjualan')->nullable();
            $table->decimal('total_bayar', 15, 2)->nullable();
            $table->decimal('uang_diterima', 15, 2)->nullable();
            $table->decimal('kembalian', 15, 2)->nullable();
            $table->timestamps();
            $table->foreign('id_akun')->references('id_akun')->on('account')->onDelete('set null');
        });
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_penjualan');
            $table->unsignedInteger('id_produk');
            $table->integer('jumlah')->nullable();
            $table->decimal('harga_beli_saat_ini', 15, 2)->nullable();
            $table->decimal('harga_jual_saat_ini', 15, 2)->nullable();
            $table->decimal('subtotal', 15, 2)->nullable();
            $table->timestamps();
            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('product')->onDelete('restrict');
        });
        Schema::create('penyesuaian_stok', function (Blueprint $table) {
            $table->increments('id_penyesuaian');
            $table->unsignedInteger('id_produk');
            $table->date('tanggal_cek')->nullable();
            $table->integer('jumlah_selisih')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->foreign('id_produk')->references('id_produk')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang');
        Schema::dropIfExists('penyesuaian_stok');
        Schema::dropIfExists('detail_penjualan');
        Schema::dropIfExists('penjualan');
        Schema::dropIfExists('pembelian_stok');
        Schema::dropIfExists('product');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('account');
    }
};
