<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KpiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CapaianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HasilEvaluasiController;
use App\Http\Controllers\MonitoringController;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Dosen;
use App\Models\Karyawan;
use App\Models\Kpi;
use App\Models\Periode;
use App\Models\Evaluasi;
use App\Models\Feedback;
use App\Models\Capaian;

Route::get('/dashboard', function () {

    return view('dashboard', [

        'totalDosen' => Dosen::count(),
        'totalKaryawan' => Karyawan::count(),
        'totalKpi' => Kpi::count(),
        'totalPeriode' => Periode::count(),
        'totalEvaluasi' => Evaluasi::count(),
        'totalFeedback' => Feedback::count(),
        'totalCapaian' => Capaian::count(),

    ]);

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/create', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);

    Route::get(
    '/hasil-evaluasi',
    [HasilEvaluasiController::class,'index']
    )->middleware('auth');

    Route::get(
    '/monitoring',
    [MonitoringController::class,'index']
    )->middleware('auth');

    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');

    Route::resource('kpi', KpiController::class);
    Route::resource('periode', PeriodeController::class);
    Route::resource('evaluasi', EvaluasiController::class);
    Route::resource('feedback', FeedbackController::class);
    Route::resource('capaian', CapaianController::class);

    Route::get(
    '/laporan/pdf',
    [LaporanController::class, 'pdf']
    )->name('laporan.pdf');
    
    Route::resource('laporan', LaporanController::class);

    Route::resource('dosen', DosenController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
