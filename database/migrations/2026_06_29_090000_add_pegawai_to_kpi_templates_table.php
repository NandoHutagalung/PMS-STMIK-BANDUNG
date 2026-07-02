<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kpi_templates', function (Blueprint $table) {
            $table->unsignedBigInteger('pegawai_id')->nullable()->after('jabatan');
            $table->string('pegawai_nama')->nullable()->after('pegawai_id');
        });
    }

    public function down(): void
    {
        Schema::table('kpi_templates', function (Blueprint $table) {
            $table->dropColumn(['pegawai_id', 'pegawai_nama']);
        });
    }
};