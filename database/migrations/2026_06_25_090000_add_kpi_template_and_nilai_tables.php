<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ===== Tabel baru: template/master KPI per kategori+unit kerja+jabatan+periode =====
        // (Tabel lama: kpis, evaluasis, capaians TIDAK dihapus dan TIDAK diubah)
        Schema::create('kpi_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
            $table->string('kategori_pegawai'); // Dosen / Pegawai
            $table->string('unit_kerja');
            $table->string('jabatan');
            $table->string('semester')->nullable();
            $table->string('status')->default('draft'); // draft / diajukan
            $table->timestamps();
        });

        // ===== Detail baris KPI di dalam satu template =====
        Schema::create('kpi_template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_template_id')->constrained('kpi_templates')->onDelete('cascade');
            $table->string('aspek');
            $table->string('indikator');
            $table->text('deskripsi')->nullable();
            $table->decimal('target', 10, 2)->default(0);
            $table->string('satuan')->nullable();
            $table->decimal('bobot', 5, 2)->default(0);
            $table->timestamps();
        });

        // ===== Header penilaian nilai KPI per pegawai per periode =====
        Schema::create('kpi_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
            $table->foreignId('kpi_template_id')->nullable()->constrained('kpi_templates')->nullOnDelete();
            $table->string('kategori_pegawai');
            $table->unsignedBigInteger('pegawai_id');
            $table->string('pegawai_nama');
            $table->string('departemen')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('catatan')->nullable();
            $table->decimal('total_nilai', 6, 2)->nullable();
            $table->string('status')->default('draft'); // draft / final
            $table->string('penilai')->nullable();
            $table->timestamps();
        });

        // ===== Detail baris nilai per indikator KPI =====
        Schema::create('kpi_nilai_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_nilai_id')->constrained('kpi_nilai')->onDelete('cascade');
            $table->foreignId('kpi_template_item_id')->nullable()->constrained('kpi_template_items')->nullOnDelete();
            $table->string('aspek')->nullable();
            $table->string('indikator')->nullable();
            $table->decimal('target', 10, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('bobot', 5, 2)->nullable();
            $table->decimal('hasil', 10, 2)->nullable();
            $table->decimal('nilai_persen', 6, 2)->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_nilai_items');
        Schema::dropIfExists('kpi_nilai');
        Schema::dropIfExists('kpi_template_items');
        Schema::dropIfExists('kpi_templates');
    }
};