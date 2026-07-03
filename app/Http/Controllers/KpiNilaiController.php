<?php

namespace App\Http\Controllers;

use App\Models\KpiTemplate;
use Illuminate\Http\Request;

class KpiNilaiController extends Controller
{
    public function getTemplateItems(Request $request)
    {
        $periodeId   = $request->periode_id;
        $kategori    = $request->kategori_pegawai;
        $jabatan     = trim($request->jabatan ?? '');
        $pegawaiNama = trim($request->pegawai_nama ?? '');

        // Fallback 1: cocok periode + kategori + jabatan + nama spesifik
        if ($pegawaiNama !== '' && $jabatan !== '') {
            $template = KpiTemplate::with('items')
                ->where('periode_id', $periodeId)
                ->where('kategori_pegawai', $kategori)
                ->whereRaw('LOWER(TRIM(jabatan)) = ?', [strtolower($jabatan)])
                ->whereRaw('LOWER(TRIM(COALESCE(pegawai_nama,""))) = ?', [strtolower($pegawaiNama)])
                ->latest()->first();

            if ($template) {
                return response()->json(['items' => $template->items, 'template_id' => $template->id]);
            }
        }

        // Fallback 2: cocok periode + kategori + jabatan (template umum)
        if ($jabatan !== '') {
            $template = KpiTemplate::with('items')
                ->where('periode_id', $periodeId)
                ->where('kategori_pegawai', $kategori)
                ->whereRaw('LOWER(TRIM(jabatan)) = ?', [strtolower($jabatan)])
                ->whereNull('pegawai_nama')
                ->latest()->first();

            if ($template) {
                return response()->json(['items' => $template->items, 'template_id' => $template->id]);
            }

            // Fallback 3: cocok periode + kategori + jabatan (apapun nama_pegawainya)
            $template = KpiTemplate::with('items')
                ->where('periode_id', $periodeId)
                ->where('kategori_pegawai', $kategori)
                ->whereRaw('LOWER(TRIM(jabatan)) = ?', [strtolower($jabatan)])
                ->latest()->first();

            if ($template) {
                return response()->json(['items' => $template->items, 'template_id' => $template->id]);
            }
        }

        // Fallback 4 (paling longgar): cocok periode + kategori saja
        // Ini hanya dipakai kalau jabatan benar-benar tidak cocok sama sekali
        $template = KpiTemplate::with('items')
            ->where('periode_id', $periodeId)
            ->where('kategori_pegawai', $kategori)
            ->latest()->first();

        if (!$template) {
            return response()->json(['items' => [], 'template_id' => null]);
        }

        return response()->json([
            'items'       => $template->items,
            'template_id' => $template->id,
        ]);
    }
}