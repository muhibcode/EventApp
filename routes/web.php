<?php

use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\EventCommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FollowRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserFollowController;
use App\Http\Controllers\UserInfoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::post('/broadcasting/auth', function () {
//     return Auth::user();
// });

Route::resource('userinfo', UserInfoController::class);
Route::resource('event', EventController::class);
Route::resource('attendee', AttendeeController::class);
Route::resource('comment', EventCommentController::class);
Route::resource('city', CityController::class);
Route::resource('follow', UserFollowController::class);
Route::resource('followreq', FollowRequestController::class);
Route::resource('notification', NotificationController::class);


require __DIR__ . '/auth.php';
