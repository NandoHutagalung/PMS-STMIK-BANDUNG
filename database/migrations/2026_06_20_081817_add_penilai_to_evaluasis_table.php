<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluasis', function (Blueprint $table) {

            $table->string('penilai')->after('kpi_id');

            $table->string('pegawai_dinilai')
                  ->after('penilai');

        });
    }

    public function down(): void
    {
        Schema::table('evaluasis', function (Blueprint $table) {

            $table->dropColumn('penilai');
            $table->dropColumn('pegawai_dinilai');

        });
    }
};