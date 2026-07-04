<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('kpi_masters');
    }

    public function down(): void
    {
        Schema::create('kpi_masters', function (Blueprint $table) {
            $table->id();
            $table->string('tipe');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('nama');
            $table->decimal('nilai', 5, 2)->nullable();
            $table->string('satuan_default')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }
};