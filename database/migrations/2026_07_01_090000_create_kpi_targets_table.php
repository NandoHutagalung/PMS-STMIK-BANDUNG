<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
            $table->string('level'); // Individu, Departemen, Institusi
            $table->unsignedBigInteger('sasaran_strategis_id')->nullable();
            $table->string('kategori_pegawai')->nullable(); // Dosen/Pegawai, khusus level Individu
            $table->string('nama_entitas')->nullable(); // nama orang (Individu) / nama departemen (Departemen) / kosong (Institusi)
            $table->string('nama_target');
            $table->decimal('target_nilai', 12, 2);
            $table->string('satuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_targets');
    }
};