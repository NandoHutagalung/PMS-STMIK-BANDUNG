<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('jabatans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_jabatan')->unique();
        $table->timestamps();
    });

    \Illuminate\Support\Facades\DB::table('jabatans')->insert([
        ['nama_jabatan' => 'Guru Besar', 'created_at' => now(), 'updated_at' => now()],
        ['nama_jabatan' => 'Ketua BPH', 'created_at' => now(), 'updated_at' => now()],
        ['nama_jabatan' => 'Ketua STMIK Bandung', 'created_at' => now(), 'updated_at' => now()],
        ['nama_jabatan' => 'Wakil Ketua STMIK Bandung', 'created_at' => now(), 'updated_at' => now()],
        ['nama_jabatan' => 'Ketua Prodi', 'created_at' => now(), 'updated_at' => now()],
        ['nama_jabatan' => 'Ketua LPPM', 'created_at' => now(), 'updated_at' => now()],
        ['nama_jabatan' => 'Kepala SDI', 'created_at' => now(), 'updated_at' => now()],
    ]);
}

public function down(): void
{
    Schema::dropIfExists('jabatans');
}
};
