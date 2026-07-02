<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kpi_nilai', function (Blueprint $table) {
            $table->text('catatan_approval')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('kpi_nilai', function (Blueprint $table) {
            $table->dropColumn('catatan_approval');
        });
    }
};