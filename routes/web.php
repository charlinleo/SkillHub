<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\SkillClassController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Participant\ClassBrowseController;

// Halaman utama: daftar kelas (guest & login boleh)
Route::get('/', [ClassBrowseController::class, 'index'])->name('classes.index');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/classes/{class}', [ClassBrowseController::class, 'show'])->name('classes.show');

// Auth::routes();

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('participants', ParticipantController::class);
    Route::resource('classes', SkillClassController::class);
    Route::get('enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('classes/{class}/enrollments', [AdminEnrollmentController::class, 'storeForClass'])
        ->name('classes.enrollments.store');
    Route::patch('enrollments/{enrollment}/status', [AdminEnrollmentController::class, 'updateStatus'])
        ->name('enrollments.updateStatus');
    Route::delete('enrollments/{enrollment}', [AdminEnrollmentController::class, 'destroy'])
        ->name('enrollments.destroy');

});

// Peserta
Route::middleware(['auth', 'role:peserta,admin'])->group(function () {
    Route::post('/classes/{class}/enroll', [ClassBrowseController::class, 'enroll'])->name('classes.enroll');
    // browse & daftar kelas
    Route::get('/participant/classes', [ClassBrowseController::class, 'index'])
        ->name('participant.classes.index');
    // Show semua kelas
    Route::get('/participant/classes/{class}', [ClassBrowseController::class, 'show'])
        ->name('participant.classes.show');
    // Request ikut kelas
    Route::post('/participant/classes/{class}/enroll', [ClassBrowseController::class, 'enroll'])
        ->name('participant.classes.enroll');
    // Kelas yang didaftar
    Route::get('/participant/my-classes', [ClassBrowseController::class, 'myClasses'])
        ->middleware('auth')
        ->name('participant.my_classes');
    // Batalkan == menghapus enrollment
    Route::delete('/participant/enrollments/{enrollment}', [ClassBrowseController::class, 'destroy'])
        ->middleware('auth')
        ->name('participant.enrollments.destroy');
});

require __DIR__ . '/auth.php';
