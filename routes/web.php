<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\KpiTemplateController;
use App\Http\Controllers\KpiNilaiController;
use App\Http\Controllers\KpiSayaController;
use App\Http\Controllers\KpiApprovalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KpiMasterController;
use App\Http\Controllers\KpiTargetController;
use App\Http\Controllers\TriDharmaController;
use App\Http\Controllers\PengembanganSdmController;

use App\Models\Dosen;
use App\Models\Karyawan;
use App\Models\KpiTemplate;
use App\Models\KpiNilai;
use App\Models\Periode;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // ===== User Management =====
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/create', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // ===== Master Data =====
    Route::resource('dosen', DosenController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('periode', PeriodeController::class);

    // ===== Manajemen KPI (template per jabatan/individu) =====
    Route::resource('kpi-template', KpiTemplateController::class);

    // ===== Master KPI (Sasaran Strategis, Kategori, Indikator, Bobot) =====
Route::get('/kpi-master/{tipe}', [KpiMasterController::class, 'index'])->name('kpi-master.index');
Route::get('/kpi-master/{tipe}/create', [KpiMasterController::class, 'create'])->name('kpi-master.create');
Route::post('/kpi-master/{tipe}', [KpiMasterController::class, 'store'])->name('kpi-master.store');
Route::get('/kpi-master/{tipe}/{id}/edit', [KpiMasterController::class, 'edit'])->name('kpi-master.edit');
Route::put('/kpi-master/{tipe}/{id}', [KpiMasterController::class, 'update'])->name('kpi-master.update');
Route::delete('/kpi-master/{tipe}/{id}', [KpiMasterController::class, 'destroy'])->name('kpi-master.destroy');

// ===== Target KPI (Individu, Departemen, Institusi) =====
Route::get('/kpi-target/{slug}', [KpiTargetController::class, 'index'])->name('kpi-target.index');
Route::get('/kpi-target/{slug}/create', [KpiTargetController::class, 'create'])->name('kpi-target.create');
Route::post('/kpi-target/{slug}', [KpiTargetController::class, 'store'])->name('kpi-target.store');
Route::get('/kpi-target/{slug}/{id}/edit', [KpiTargetController::class, 'edit'])->name('kpi-target.edit');
Route::put('/kpi-target/{slug}/{id}', [KpiTargetController::class, 'update'])->name('kpi-target.update');
Route::delete('/kpi-target/{slug}/{id}', [KpiTargetController::class, 'destroy'])->name('kpi-target.destroy');


// ===== Sumber indikator KPI (dipakai bersama oleh Input Realisasi karyawan) =====
    Route::get('/kpi-nilai/get-template-items', [KpiNilaiController::class, 'getTemplateItems'])
        ->name('kpi-nilai.get-template-items');

    // ===== Approval KPI (satu pintu: template & nilai) =====
    Route::get('/kpi-approval', [KpiApprovalController::class, 'index'])->name('kpi-approval.index');
    Route::get('/kpi-approval/template/{id}', [KpiApprovalController::class, 'show'])->name('kpi-approval.show');
    Route::post('/kpi-approval/template/{id}/approve', [KpiApprovalController::class, 'approve'])->name('kpi-approval.approve');
    Route::post('/kpi-approval/template/{id}/reject', [KpiApprovalController::class, 'reject'])->name('kpi-approval.reject');
    Route::get('/kpi-approval/nilai/{id}', [KpiApprovalController::class, 'showNilai'])->name('kpi-approval.show-nilai');
    Route::post('/kpi-approval/nilai/{id}/approve', [KpiApprovalController::class, 'approveNilai'])->name('kpi-approval.approve-nilai');
    Route::post('/kpi-approval/nilai/{id}/reject', [KpiApprovalController::class, 'rejectNilai'])->name('kpi-approval.reject-nilai');

    // ===== Tri Dharma Dosen =====
    Route::resource('tri-dharma', TriDharmaController::class);

    // ===== Pengembangan SDM Karyawan =====
    Route::resource('pengembangan-sdm', PengembanganSdmController::class);

    // ===== KPI Saya (Dosen: lihat; Karyawan: input realisasi + lihat) =====
    Route::get('/kpi-saya', [KpiSayaController::class, 'index'])->name('kpi-saya.index');
    Route::get('/kpi-saya/show/{id}', [KpiSayaController::class, 'show'])->name('kpi-saya.show');
    Route::get('/kpi-saya/grafik', [KpiSayaController::class, 'grafik'])->name('kpi-saya.grafik');
    Route::get('/kpi-saya/input', [KpiSayaController::class, 'inputForm'])->name('kpi-saya.input');
    Route::post('/kpi-saya/input', [KpiSayaController::class, 'inputStore'])->name('kpi-saya.input.store');
    Route::get('/kpi-saya/existing', [KpiSayaController::class, 'getMyExisting'])->name('kpi-saya.existing');

    // ===== Hasil Evaluasi & Monitoring =====
    Route::get('/hasil-evaluasi', [HasilEvaluasiController::class, 'index'])->middleware('auth');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->middleware('auth')->name('monitoring.index');

    // ===== Profile =====
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';