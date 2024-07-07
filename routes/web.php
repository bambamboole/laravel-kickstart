<?php declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Projects\CreateProjectController;
use App\Http\Controllers\Projects\ProjectOverviewController;
use App\Http\Controllers\Projects\ProjectSettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function (Request $request) {

    return Inertia::render('Dashboard', [
        'projects' => $request->user()->projects()->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/projects', CreateProjectController::class)->name('projects.create');
    Route::get('/projects/{uuid}', ProjectOverviewController::class)->name('projects.overview');
    Route::get('/projects/{uuid}/settings', ProjectSettingsController::class)->name('projects.settings');
});

require __DIR__.'/auth.php';
