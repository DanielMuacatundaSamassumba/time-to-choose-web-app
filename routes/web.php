<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContactController;

// ─── Public Routes ────────────────────────────────────────────────────────────

Route::get('/', function () {
    $featured = \App\Models\Property::where('is_active', true)
        ->where('is_featured', true)
        ->take(6)->get();
    return view('index', compact('featured'));
});

Route::get('/sobre-nos', fn() => view('pages.about-us'));
Route::get('/avaliacao-de-imoveis', fn() => view('pages.imovel-avaliation'));
Route::get('/investidores', fn() => view('pages.investers'));
Route::get('/gestao-de-propriedades', fn() => view('pages.maneger-property'));
Route::get('/propriedades-e-parceiros', fn() => view('pages.property-and-partners'));

// Properties (public, dynamic)
Route::get('/imoveis', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/imoveis/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Contact form
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

// ─── Admin Auth ───────────────────────────────────────────────────────────────

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ─── Admin Panel (protected) ──────────────────────────────────────────────────

Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Properties CRUD
    Route::get('/imoveis',                  [AdminDashboardController::class, 'propertiesIndex'])->name('properties.index');
    Route::get('/imoveis/criar',            [AdminDashboardController::class, 'propertiesCreate'])->name('properties.create');
    Route::post('/imoveis',                 [AdminDashboardController::class, 'propertiesStore'])->name('properties.store');
    Route::get('/imoveis/{property}/editar',[AdminDashboardController::class, 'propertiesEdit'])->name('properties.edit');
    Route::put('/imoveis/{property}',       [AdminDashboardController::class, 'propertiesUpdate'])->name('properties.update');
    Route::delete('/imoveis/{property}',    [AdminDashboardController::class, 'propertiesDestroy'])->name('properties.destroy');

    // Messages
    Route::get('/mensagens',                 [AdminDashboardController::class, 'messagesIndex'])->name('messages.index');
    Route::delete('/mensagens/{message}',    [AdminDashboardController::class, 'messagesDestroy'])->name('messages.destroy');
});
