<?php declare(strict_types=1);

use App\Enum\ApiAbility;
use App\Http\Controllers\Api\InfoApiController;
use App\Http\Controllers\Api\MembersApiController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/info', InfoApiController::class)->middleware(['auth:sanctum', 'ability:'.ApiAbility::INFO->value]);
Route::get('/v1/members', [MembersApiController::class, 'index'])->middleware(['auth:sanctum', 'ability:'.ApiAbility::MEMBERS_LIST->value]);
Route::delete('/v1/members/{uuid}', [MembersApiController::class, 'delete'])->middleware(['auth:sanctum', 'ability:'.ApiAbility::MEMBERS_REMOVE->value]);
