<?php declare(strict_types=1);

use App\Http\Controllers\Api\ProjectInfoApiController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/info', ProjectInfoApiController::class)->middleware(['auth:sanctum', 'ability:info']);
