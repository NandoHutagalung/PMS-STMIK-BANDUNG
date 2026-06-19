<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('capaians', function (Blueprint $table) {

        $table->id();

        $table->foreignId('periode_id');

        $table->foreignId('kpi_id');

        $table->string('pegawai');

        $table->string('jabatan');

        $table->integer('target');

        $table->integer('realisasi');

        $table->integer('persentase');

        $table->text('keterangan')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capaians');
    }
};
