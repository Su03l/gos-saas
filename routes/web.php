<?php

declare(strict_types=1);

use App\Http\Controllers\GuestAgendaController;
use App\Http\Controllers\Tenant\AgendaController;
use App\Http\Controllers\Tenant\CoiController;
use App\Http\Controllers\Tenant\DocumentController;
use App\Http\Controllers\Tenant\ExecutionTaskController;
use App\Http\Controllers\Tenant\MeetingController;
use App\Http\Controllers\Tenant\ResolutionController;
use App\Http\Middleware\TenantIsolationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Central Routes (Super Admin)
|--------------------------------------------------------------------------
*/
Route::domain(config('app.central_domain', 'admin.governance.test'))->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('central.home');

    Route::middleware(['auth'])->group(function () {
        // Super Admin Dashboard, Tenant Management, etc.
        Route::get('/dashboard', function () {
            return "Central Dashboard";
        })->name('central.dashboard');

        Route::post('/billing/checkout/{plan}', [\App\Http\Controllers\Central\BillingController::class, 'checkout'])->name('central.billing.checkout');
        Route::get('/billing/portal', [\App\Http\Controllers\Central\BillingController::class, 'portal'])->name('central.billing.portal');
        Route::get('/health', \App\Http\Controllers\Central\HealthCheckController::class)->name('central.health');
    });
});


/*
|--------------------------------------------------------------------------
| Tenant Routes (Company Workspace)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', TenantIsolationMiddleware::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('tenant.dashboard');
    })->name('tenant.dashboard');

    // Meeting Management
    Route::resource('meetings', MeetingController::class);
    Route::post('meetings/{meeting}/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::patch('agenda/{agenda_item}', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('agenda/{agenda_item}', [AgendaController::class, 'destroy'])->name('agenda.destroy');

    // VDR Documents
    Route::post('agenda/{agenda_item}/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('documents/{media}', [DocumentController::class, 'show'])->name('documents.show');

    // Resolutions & Voting
    Route::resource('resolutions', ResolutionController::class);
    Route::post('resolutions/{resolution}/vote', [ResolutionController::class, 'castVote'])->name('resolutions.vote');

    // Execution Tasks
    Route::get('tasks', [ExecutionTaskController::class, 'index'])->name('tasks.index');
    Route::post('tasks/{task}/evidence', [ExecutionTaskController::class, 'submitEvidence'])->name('tasks.evidence');

    // COI Declaration
    Route::get('meetings/{meeting}/coi', [CoiController::class, 'create'])->name('coi.create');
    Route::post('meetings/{meeting}/coi', [CoiController::class, 'store'])->name('coi.store');

    // API Token Management
    Route::get('settings/api', function (\Illuminate\Http\Request $request) {
        return view('tenant.settings.api', [
            'tokens' => $request->user()->tokens,
        ]);
    })->name('tenant.settings.api');
    Route::post('settings/api/tokens', [\App\Http\Controllers\Tenant\ApiTokenController::class, 'store'])->name('tenant.api-tokens.store');
    Route::delete('settings/api/tokens/{token}', [\App\Http\Controllers\Tenant\ApiTokenController::class, 'destroy'])->name('tenant.api-tokens.destroy');
});

/*
|--------------------------------------------------------------------------
| Guest Access (Signed URLs)
|--------------------------------------------------------------------------
*/
Route::get('/guest/agenda/{agenda_item}', [GuestAgendaController::class, 'show'])
    ->name('guest.agenda.show')
    ->middleware('signed');

Route::get('/', function () {
    return redirect()->route('tenant.dashboard');
});
