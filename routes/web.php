<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AUTH\LoginController;
use App\Http\Controllers\ADMIN\BadgeController;
use App\Http\Controllers\ADMIN\UsersController;
use App\Http\Controllers\ADMIN\MarcheController;
use App\Http\Controllers\AUTH\LanguesController;
use App\Http\Controllers\AUTH\WaitingController;
use App\Http\Controllers\ADMIN\ProfileController;
use App\Http\Controllers\AUTH\RegisterController;
use App\Http\Controllers\ADMIN\ActualiteController;
use App\Http\Controllers\ADMIN\DashboardController;
use App\Http\Controllers\ADMIN\ProducteurController;


use App\Http\Controllers\FRONT\FrontMarcheController;
use App\Http\Controllers\FRONT\FrontofficeController;
use App\Http\Controllers\AUTH\ResetPasswordController;
use App\Http\Controllers\AUTH\ForgetPasswordController;
use App\Http\Controllers\FRONT\FrontActualiteController;
use App\Http\Controllers\FRONT\FrontEntrepriseController;

use App\Http\Controllers\FRONT\FrontProducteurController;
use App\Http\Controllers\ADMIN\EntrepriseExportatriceController;
use App\Http\Controllers\ADMIN\EntrepriseImportatriceController;

Route::get('/', [FrontofficeController::class, 'index'])->name('frontoffice');
Route::get('lang/{lang}', [LanguesController::class, 'changeLanguage'])->name('lang');
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');

Route::group(['middleware' => 'guest'], function(){
    // Login
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    Route::get('/forget-password', [ForgetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forget-password', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
});

Route::middleware('auth')->group(function(){
    Route::get('/waiting/user', [WaitingController::class, 'waiting'])->name('status.not.approuved');
    Route::post('/logout', [UsersController::class, 'logout'])->name('logout');
});

Route::get('/', FrontofficeController::class)->name('frontoffice');

Route::view('/marche', 'frontoffice.marche.index')->name('front.marche.index');
Route::get('/marche', [FrontMarcheController::class, 'index'])->name('front.marche.index');
Route::get('/producteurs', [FrontProducteurController::class, 'index'])->name('front.producteurs.index');
Route::get('/entreprises', [FrontEntrepriseController::class, 'index'])->name('front.entreprises.index');

Route::get('/actualites', [FrontActualiteController::class, 'index'])->name('front.actualites.index');
Route::get('/actualites/{actualite}', [FrontActualiteController::class, 'show'])->name('front.actualites.show');

Route::prefix('backoffice')->name('admin.')->middleware(['auth','check.status'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/badge',[BadgeController::class, 'getAll'])->name('badge');
    Route::resource('producteurs', ProducteurController::class);
    Route::resource('marches', MarcheController::class);
    Route::resource('actualites', ActualiteController::class);
    Route::resource('entreprises_exportatrices', EntrepriseExportatriceController::class);
    Route::resource('entreprises_importatrices', EntrepriseImportatriceController::class);
    Route::resource('users', UsersController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
