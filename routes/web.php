<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DashboardMetricsController;
use App\Http\Controllers\Api\OpportunityController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\SystemStatusController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketMessageController;
use App\Http\Middleware\EnsureLicenseIsValid;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/kurumsal', function () {
    return Inertia::render('corporate/About', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('corporate.about');

Route::get('/cozumler', function () {
    return Inertia::render('corporate/Solutions', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('corporate.solutions');

Route::get('/iletisim', function () {
    return Inertia::render('corporate/Contact', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('corporate.contact');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', EnsureLicenseIsValid::class])
    ->prefix('api')
    ->name('api.')
    ->group(function (): void {
        Route::get('/dashboard/metrics', DashboardMetricsController::class)->name('dashboard.metrics');
        Route::get('/system/status', SystemStatusController::class)->name('system.status');

        Route::get('/opportunities/pipeline-summary', [OpportunityController::class, 'pipelineSummary'])
            ->name('opportunities.pipeline-summary');
        Route::post('/tasks/{task}/move', [TaskController::class, 'move'])->name('tasks.move');
        Route::post('/tickets/{ticket}/messages', [TicketMessageController::class, 'store'])->name('tickets.messages.store');
        Route::get('/quotes/{quote}/pdf', [QuoteController::class, 'exportPdf'])->name('quotes.pdf');

        Route::apiResource('companies', CompanyController::class);
        Route::apiResource('contacts', ContactController::class);
        Route::apiResource('opportunities', OpportunityController::class);
        Route::apiResource('quotes', QuoteController::class)->except(['create', 'edit']);
        Route::apiResource('tasks', TaskController::class)->except(['create', 'edit']);
        Route::apiResource('tickets', TicketController::class)->except(['create', 'edit']);
    });

require __DIR__.'/settings.php';
