<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jabatans', function (Blueprint $table) {
            $table->enum('jenis', ['karyawan', 'dosen'])->default('karyawan')->after('nama_jabatan');
        });

        // Set jabatan dosen
        \Illuminate\Support\Facades\DB::table('jabatans')
            ->where('nama_jabatan', 'Guru Besar')
            ->update(['jenis' => 'dosen']);

        // Tambah jabatan fungsional dosen yang belum ada
        $dosenJabatans = ['Asisten Ahli', 'Lektor', 'Lektor Kepala'];
        foreach ($dosenJabatans as $nama) {
            if (!\Illuminate\Support\Facades\DB::table('jabatans')->where('nama_jabatan', $nama)->exists()) {
                \Illuminate\Support\Facades\DB::table('jabatans')->insert([
                    'nama_jabatan' => $nama,
                    'jenis' => 'dosen',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('jabatans', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
    }
};