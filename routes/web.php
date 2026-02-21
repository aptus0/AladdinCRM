<?php

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

require __DIR__.'/settings.php';
