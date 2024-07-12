<?php declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Projects\ProjectMembersController;
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
    Route::post('/projects', [ProjectController::class, 'create'])->name('project.create');
    Route::get('/projects/{uuid}', [ProjectController::class, 'show'])->name('project.overview');
    Route::delete('/projects/{uuid}', [ProjectController::class, 'delete'])->name('project.delete');
    Route::get('/projects/{uuid}/settings', [ProjectController::class, 'settings'])->name('project.settings');
    Route::get('/projects/{uuid}/members', [ProjectMembersController::class, 'index'])->name('project.members.index');
});

require __DIR__.'/auth.php';
