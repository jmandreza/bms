<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\RequestStatusController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(Auth::check()) {
        return Auth::user()->admin ? redirect()->route('admin.home') : redirect()->route('resident.home');
    }
    return view('welcome');
});

// Resident Route
Route::group(['middleware' => ['auth', 'resident'], 'prefix' => 'resident', 'as' => 'resident.'], function() {
    // Home Route
    Route::get('/', [HomeController::class, 'resident'])->name('home');

    // Document Request Route
    Route::resource('request', DocumentRequestController::class);

    // Document Request Status Route
    Route::resource('request-status', RequestStatusController::class);

    // Contact Us Route
    Route::resource('contact-us', ContactUsController::class);
});

// Admin Route
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function() {
    // Dashboard Route
    Route::get('/', [HomeController::class, 'admin'])->name('home');

    // Document Request Management Route
    Route::resource('request-status', RequestStatusController::class);

    // User Management Route
    Route::resource('users', UserController::class);
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
