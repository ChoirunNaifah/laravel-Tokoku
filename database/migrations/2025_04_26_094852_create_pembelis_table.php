<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembelis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->text('alamat');
            $table->string('no_hp');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelis');
    }
};
