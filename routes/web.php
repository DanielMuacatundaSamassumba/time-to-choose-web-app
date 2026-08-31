<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PropertyTypeController;
use App\Models\PageSection;

// --- Public Routes ---

Route::get('/', function () {
    $featured = \App\Models\Property::where('is_active', true)
        ->where('is_featured', true)
        ->where('country', '=', 'Angola')
        ->take(6)->get();
    $sections = PageSection::getForPage('home');
    return view('index', compact('featured', 'sections'));
});

Route::get('/sobre-nos', function () {
    $sections = PageSection::getForPage('about');
    return view('pages.about-us', compact('sections'));
});

Route::get('/avaliacao-de-imoveis', function () {
    $sections = PageSection::getForPage('valuation');
    return view('pages.imovel-avaliation', compact('sections'));
});

Route::get('/investidores', function () {
    $sections = PageSection::getForPage('investors');
    return view('pages.investers', compact('sections'));
});

Route::get('/gestao-de-propriedades', function () {
    $sections = PageSection::getForPage('management');
    return view('pages.maneger-property', compact('sections'));
});

Route::get('/propriedades-e-parceiros', function () {
    $sections = PageSection::getForPage('partners');
    return view('pages.property-and-partners', compact('sections'));
});

// Properties (public, dynamic)
Route::get('/imoveis', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/imoveis/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');

// Contact form
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

// --- Admin Auth ---

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.post')->middleware('throttle:5,5');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// --- Admin Panel (protected) ---

Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Properties CRUD
    Route::get('/imoveis',                        [AdminDashboardController::class, 'propertiesIndex'])->name('properties.index');
    Route::get('/imoveis/criar',                  [AdminDashboardController::class, 'propertiesCreate'])->name('properties.create');
    Route::post('/imoveis',                       [AdminDashboardController::class, 'propertiesStore'])->name('properties.store');
    Route::get('/imoveis/{property}/ficha',       [AdminDashboardController::class, 'propertiesShow'])->name('properties.show');
    Route::get('/imoveis/{property}/editar',      [AdminDashboardController::class, 'propertiesEdit'])->name('properties.edit');
    Route::put('/imoveis/{property}',             [AdminDashboardController::class, 'propertiesUpdate'])->name('properties.update');
    Route::patch('/imoveis/{property}/visibilidade',[AdminDashboardController::class, 'propertiesToggleActive'])->name('properties.toggle-active');
    Route::delete('/imoveis/{property}',          [AdminDashboardController::class, 'propertiesDestroy'])->name('properties.destroy');

    // Messages
    Route::get('/mensagens',              [AdminDashboardController::class, 'messagesIndex'])->name('messages.index');
    Route::delete('/mensagens/{message}', [AdminDashboardController::class, 'messagesDestroy'])->name('messages.destroy');

    // Content / Page Sections CMS
    Route::get('/conteudo',         [AdminDashboardController::class, 'contentIndex'])->name('content.index');
    Route::get('/conteudo/{page}',  [AdminDashboardController::class, 'contentEdit'])->name('content.edit');
    Route::post('/conteudo/{page}', [AdminDashboardController::class, 'contentUpdate'])->name('content.update');

    // Configuracoes Globais
    Route::get('/configuracoes',  [ConfiguracoesController::class, 'index'])->name('settings.index');
    Route::put('/configuracoes',  [ConfiguracoesController::class, 'update'])->name('settings.update');

    // Utilizadores Administradores
    Route::get('/utilizadores',                   [UserController::class, 'index'])->name('users.index');
    Route::get('/utilizadores/criar',             [UserController::class, 'create'])->name('users.create');
    Route::post('/utilizadores',                  [UserController::class, 'store'])->name('users.store');
    Route::get('/utilizadores/{user}/editar',     [UserController::class, 'edit'])->name('users.edit');
    Route::put('/utilizadores/{user}',            [UserController::class, 'update'])->name('users.update');
    Route::delete('/utilizadores/{user}',         [UserController::class, 'destroy'])->name('users.destroy');

// Localizações (Países e Cidades)
Route::get('/localizacoes', [LocationController::class, 'index'])
    ->name('locations.index');

Route::post('/localizacoes/paises', [LocationController::class, 'storeCountry'])
    ->name('locations.countries.store');

Route::put('/localizacoes/paises/{country}', [LocationController::class, 'updateCountry'])
    ->name('locations.countries.update');

Route::delete('/localizacoes/paises/{country}', [LocationController::class, 'destroyCountry'])
    ->name('locations.countries.destroy');

Route::post('/localizacoes/cidades', [LocationController::class, 'storeCity'])
    ->name('locations.cities.store');

Route::put('/localizacoes/cidades/{city}', [LocationController::class, 'updateCity'])
    ->name('locations.cities.update');

Route::delete('/localizacoes/cidades/{city}', [LocationController::class, 'destroyCity'])
    ->name('locations.cities.destroy');


    // Tipos de Imóvel
    Route::get('/tipos-imovel', [PropertyTypeController::class, 'index'])
        ->name('property-types.index');

    Route::post('/tipos-imovel', [PropertyTypeController::class, 'store'])
        ->name('property-types.store');

    Route::put('/tipos-imovel/{propertyType}', [PropertyTypeController::class, 'update'])
        ->name('property-types.update');

    Route::delete('/tipos-imovel/{propertyType}', [PropertyTypeController::class, 'destroy'])
        ->name('property-types.destroy');
        
    // Media / Biblioteca de Imagens
    Route::get('/media',    [MediaController::class, 'index'])->name('media.index');
    Route::delete('/media', [MediaController::class, 'destroy'])->name('media.destroy');
});