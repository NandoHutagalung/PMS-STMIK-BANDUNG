<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('kpi_templates')->where('kategori_pegawai', 'Pegawai')->update(['kategori_pegawai' => 'Karyawan']);
        DB::table('kpi_nilai')->where('kategori_pegawai', 'Pegawai')->update(['kategori_pegawai' => 'Karyawan']);
        DB::table('kpi_targets')->where('kategori_pegawai', 'Pegawai')->update(['kategori_pegawai' => 'Karyawan']);
    }

    public function down(): void
    {
        DB::table('kpi_templates')->where('kategori_pegawai', 'Karyawan')->update(['kategori_pegawai' => 'Pegawai']);
        DB::table('kpi_nilai')->where('kategori_pegawai', 'Karyawan')->update(['kategori_pegawai' => 'Pegawai']);
        DB::table('kpi_targets')->where('kategori_pegawai', 'Karyawan')->update(['kategori_pegawai' => 'Pegawai']);
    }
};