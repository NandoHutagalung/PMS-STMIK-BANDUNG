<?php

namespace App\Http\Controllers;

use App\Models\KpiTemplate;
use Illuminate\Http\Request;

class KpiNilaiController extends Controller
{
    // Dipakai oleh Karyawan (Input Realisasi) untuk mengambil daftar indikator dari template KPI yang aktif
    public function getTemplateItems(Request $request)
    {
        $base = KpiTemplate::with('items')
            ->where('periode_id', $request->periode_id)
            ->where('kategori_pegawai', $request->kategori_pegawai)
            ->where('jabatan', $request->jabatan);

        $template = null;

        if ($request->filled('pegawai_nama')) {
            $template = (clone $base)->where('pegawai_nama', $request->pegawai_nama)->latest()->first();
        }

        if (!$template) {
            $template = (clone $base)->whereNull('pegawai_nama')->latest()->first();
        }

        if (!$template) {
            $template = $base->latest()->first();
        }

        if (!$template) {
            return response()->json(['items' => [], 'template_id' => null]);
        }

        return response()->json([
            'items' => $template->items,
            'template_id' => $template->id,
        ]);
    }
}