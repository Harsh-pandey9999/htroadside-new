<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\Admin\CareerController as AdminCareerController;

// Public Career Routes
Route::prefix('careers')->name('careers.')->group(function () {
    Route::get('/', [CareerController::class, 'index'])->name('index');
    Route::get('/{slug}', [CareerController::class, 'show'])->name('show');
    Route::get('/{slug}/apply', [CareerController::class, 'apply'])->name('apply');
    Route::post('/{slug}/apply', [CareerController::class, 'submitApplication'])->name('submit-application');
});

// Admin Career Routes
Route::prefix('admin/careers')->name('admin.careers.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminCareerController::class, 'index'])->name('index');
    Route::get('/create', [AdminCareerController::class, 'create'])->name('create');
    Route::post('/', [AdminCareerController::class, 'store'])->name('store');
    Route::get('/{career}', [AdminCareerController::class, 'show'])->name('show');
    Route::get('/{career}/edit', [AdminCareerController::class, 'edit'])->name('edit');
    Route::put('/{career}', [AdminCareerController::class, 'update'])->name('update');
    Route::delete('/{career}', [AdminCareerController::class, 'destroy'])->name('destroy');
    
    // Application management routes
    Route::get('/{career}/applications', [AdminCareerController::class, 'applications'])->name('applications');
    Route::get('/applications/all', [AdminCareerController::class, 'allApplications'])->name('all-applications');
    Route::get('/applications/{application}', [AdminCareerController::class, 'showApplication'])->name('show-application');
    Route::post('/applications/{application}/status', [AdminCareerController::class, 'updateApplicationStatus'])->name('update-application-status');
});
