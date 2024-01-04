<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ConcernsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageRequestController;
use App\Http\Controllers\NotificationController;
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
    return redirect()->route('guest.home');
});

// Guest Route
Route::group(['prefix' => 'guest', 'as' => 'guest.'], function() {
    Route::get('/', function() {
        return view('index');
    })->name('home');

    // Contact Us Route
    Route::resource('contact-us', ContactUsController::class);
});

// Resident Route
Route::group(['middleware' => ['auth', 'resident'], 'prefix' => 'resident', 'as' => 'resident.'], function() {
    // Home Route
    Route::get('/', [HomeController::class, 'resident'])->name('home');

    // Document Request Route
    Route::resource('request', DocumentRequestController::class);

    // Document Request Status Route
    Route::post('my-request/search', [RequestStatusController::class, 'search'])->name('my-request.search');
    Route::get('my-request/{document_request}/preview', [RequestStatusController::class, 'preview'])->name('my-request.preview');
    Route::resource('my-request', RequestStatusController::class)->parameters(['my-request' => 'document-request']);

    // History Route
    Route::get('history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('history/{request}/preview', [HistoryController::class, 'preview'])->name('history.preview');
    Route::get('history/{request}', [HistoryController::class, 'show'])->name('history.show');
    Route::post('history/search', [HistoryController::class, 'search'])->name('history.search');

    // Contact Us Route
    Route::resource('contact-us', ContactUsController::class);
});

// Admin Route
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function() {
    // Dashboard Route
    Route::post('/statictics/filter', [HomeController::class, 'filterData'])->name('filter-statistics');
    Route::get('/statistics', [HomeController::class, 'getData'])->name('get-statistics');
    Route::get('/', [HomeController::class, 'admin'])->name('home');

    // Document Request Management Route
    Route::post('document-request/search', [ManageRequestController::class, 'search'])->name('document-request.search');
    Route::put('document-request/mark-as-completed', [ManageRequestController::class, 'markAsCompleted'])->name('document-request.mark-as-completed');
    Route::resource('document-request', ManageRequestController::class);

    // Resident Management Route
    Route::post('residents/search', [UserController::class, 'search'])->name('residents.search');
    Route::resource('residents', UserController::class)->parameters(['residents' => 'user']);

    // History Route
    Route::get('history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('history/{request}/preview', [HistoryController::class, 'preview'])->name('history.preview');
    Route::post('history/search', [HistoryController::class, 'search'])->name('history.search');

    // Concerns Route
    Route::post('concerns/search', [ConcernsController::class, 'search'])->name('concerns.search');
    Route::get('concerns/{preview}/preview', [ConcernsController::class, 'preview'])->name('concerns.preview');
    Route::resource('concerns', ConcernsController::class)->only(['index', 'show', 'update']);
});

// Notification Route for all user type
Route::group(['middleware' => 'auth', 'prefix' => 'notification'], function() {
    Route::get('unread', [NotificationController::class, 'unreadNotification'])->name('unread');
    Route::get('{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
    Route::post('mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'updatePersonal'])->name('profile.update-personal');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
