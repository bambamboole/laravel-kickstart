<?php declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Projects\ProjectApiTokenController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Projects\ProjectInvitationController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        return Inertia::render('Dashboard', [
            'projects' => $request->user()->projects()->get(),
        ]);
    })->name('dashboard');

    Route::post('/projects', [ProjectController::class, 'create'])->name('project.create');
    Route::get('/projects/{project:uuid}', [ProjectController::class, 'show'])->name('project.overview')->middleware('can:view,project');
    Route::delete('/projects/{project:uuid}', [ProjectController::class, 'delete'])->name('project.delete')->middleware('can:delete,project');

    Route::get('/projects/{project:uuid}/settings', [ProjectController::class, 'settings'])->name('project.settings')->middleware('can:viewSettings,project');

    Route::get('/projects/{project:uuid}/members', [ProjectMembersController::class, 'index'])->name('project.members.index')->middleware('can:viewMembers,project');
    Route::delete('/projects/{project:uuid}/members/{uuid}', [ProjectMembersController::class, 'delete'])->name('project.members.delete')->middleware('can:deleteMembers,project');

    Route::post('/projects/{project:uuid}/invitations', [ProjectInvitationController::class, 'create'])->name('project.invitations.create')->middleware('can:inviteMembers,project');
    Route::delete('/projects/{project:uuid}/invitations/{uuid}', [ProjectInvitationController::class, 'delete'])->name('project.invitations.delete')->middleware('can:deleteInvitations,project');

    Route::post('/projects/{project:uuid}/api-tokens', [ProjectApiTokenController::class, 'create'])->name('project.api-tokens.create')->middleware('can:createApiTokens,project');
    Route::delete('/projects/{project:uuid}/api-tokens/{tokenId}', [ProjectApiTokenController::class, 'delete'])->name('project.api-tokens.delete')->middleware('can:deleteApiTokens,project');
});
Route::get('/accept-project-invitation/{uuid}', [ProjectInvitationController::class, 'accept'])->middleware(['signed'])->name('project.invitations.accept');

require __DIR__.'/auth.php';
