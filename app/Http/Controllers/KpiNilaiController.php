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

        // Normalkan: Pegawai dan Karyawan dianggap sama
        $kategoriList = $kategori === 'Pegawai'
            ? ['Pegawai', 'Karyawan']
            : [$kategori];

        $base = KpiTemplate::with('items')
            ->where('periode_id', $periodeId)
            ->whereIn('kategori_pegawai', $kategoriList);

        if ($jabatan !== '') {
            $base->whereRaw('LOWER(TRIM(jabatan)) = ?', [strtolower($jabatan)]);
        }

        $template = null;

        // 1. Cocok nama spesifik
        if ($pegawaiNama !== '') {
            $template = (clone $base)
                ->whereRaw('LOWER(TRIM(COALESCE(pegawai_nama,""))) = ?', [strtolower($pegawaiNama)])
                ->latest()->first();
        }

        // 2. Template umum (pegawai_nama kosong/null)
        if (!$template) {
            $template = (clone $base)
                ->whereNull('pegawai_nama')
                ->latest()->first();
        }

        // 3. Fallback: apapun nama_pegawainya asal periode+kategori+jabatan cocok
        if (!$template) {
            $template = (clone $base)->latest()->first();
        }

        // 4. Paling longgar: hanya cocok periode + kategori
        if (!$template) {
            $template = KpiTemplate::with('items')
                ->where('periode_id', $periodeId)
                ->whereIn('kategori_pegawai', $kategoriList)
                ->latest()->first();
        }

        if (!$template) {
            return response()->json(['items' => [], 'template_id' => null]);
        }

        return response()->json([
            'items'       => $template->items,
            'template_id' => $template->id,
        ]);
    }
}