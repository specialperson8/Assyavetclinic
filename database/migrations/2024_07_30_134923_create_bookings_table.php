<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('nama');
            $table->string('nama_hewan');
            $table->integer('berat_hewan')->nullable();
            $table->string('jenis_hewan')->nullable();
            $table->string('alamat');
            $table->string('telpon');
            $table->date('tanggal');
            $table->date('keluar')->nullable();
            $table->text('keluhan')->nullable();
            $table->foreignId('karyawan1')->nullable()->default(null)->constrained('users')->nullOnDelete();
            $table->foreignId('karyawan2')->nullable()->default(null)->constrained('users')->nullOnDelete();
            $table->foreignId('karyawan3')->nullable()->default(null)->constrained('users')->nullOnDelete();
            $table->integer('dp')->default(0)->nullable();
            $table->integer('total')->default(0)->nullable();
            $table->string('status')->default('belum dikerjakan');
            $table->string('catatan')->nullable();
            $table->integer('diskon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
