<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_masters', function (Blueprint $table) {
            $table->id();
            $table->string('tipe'); // sasaran_strategis, kategori, indikator, bobot
            $table->unsignedBigInteger('parent_id')->nullable(); // indikator -> kategori
            $table->string('nama');
            $table->decimal('nilai', 5, 2)->nullable(); // khusus tipe bobot
            $table->string('satuan_default')->nullable(); // khusus tipe indikator
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_masters');
    }
};