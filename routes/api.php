<?php declare(strict_types=1);

use App\Http\Resource\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/v1/info', function (Request $request) {
    return new ProjectResource($request->project()->load(['members.pivot.role', 'invitations.role', 'tokens']));
})->middleware(['auth:sanctum', 'ability:info']);
