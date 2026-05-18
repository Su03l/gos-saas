<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ResolutionApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('resolutions', ResolutionApiController::class)->only(['index', 'show']);
});
