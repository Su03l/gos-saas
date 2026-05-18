<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ResolutionApiController;
use App\Http\Controllers\Api\MobileAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Mobile App Routes
Route::prefix('mobile')->group(function () {
    Route::post('/login', [MobileAuthController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('resolutions', ResolutionApiController::class)->only(['index', 'show']);
});
