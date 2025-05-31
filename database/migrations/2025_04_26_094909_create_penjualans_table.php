<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembeli_id')->constrained('pembelis')->onDelete('cascade');
            $table->foreignId('kasir_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_pesan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
