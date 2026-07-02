<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kpi_templates', function (Blueprint $table) {
            $table->text('catatan_approval')->nullable()->after('status');
            $table->string('disetujui_oleh')->nullable()->after('catatan_approval');
            $table->timestamp('disetujui_at')->nullable()->after('disetujui_oleh');
        });
    }

    public function down(): void
    {
        Schema::table('kpi_templates', function (Blueprint $table) {
            $table->dropColumn(['catatan_approval', 'disetujui_oleh', 'disetujui_at']);
        });
    }
};