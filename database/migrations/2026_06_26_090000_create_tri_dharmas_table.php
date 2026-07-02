<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tri_dharmas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
            $table->unsignedBigInteger('dosen_id')->nullable();
            $table->string('dosen_nama');
            $table->string('kategori'); // Pengajaran, Penelitian, Pengabdian, Penunjang
            $table->string('judul_kegiatan');
            $table->string('peran')->nullable(); // Dosen Pengampu / Ketua Peneliti / Anggota, dll
            $table->decimal('sks_jam', 8, 2)->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('keterangan_bukti')->nullable(); // link/nomor SK/catatan bukti
            $table->string('status')->default('Diajukan'); // Diajukan / Diverifikasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tri_dharmas');
    }
};