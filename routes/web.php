<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
|
| Guests can browse the catalog and item availability. Authenticated users can
| still visit public pages, while borrow actions are restricted to regular users.
|
*/

Route::get('/', 'App\Http\Controllers\Public\HomeController@index')->name('home');
Route::get('/catalog', 'App\Http\Controllers\Public\CatalogController@index')->name('catalog.index');
Route::get('/catalog/{item:slug}', 'App\Http\Controllers\Public\CatalogController@show')->name('catalog.show');

Route::middleware(['redirect.authenticated.by.role', 'guest'])->group(function () {
    Route::get('/login', 'App\Http\Controllers\Auth\AuthenticatedSessionController@create')->name('login');
    Route::post('/login', 'App\Http\Controllers\Auth\AuthenticatedSessionController@store');
    Route::get('/register', 'App\Http\Controllers\Auth\RegisteredUserController@create')->name('register');
    Route::post('/register', 'App\Http\Controllers\Auth\RegisteredUserController@store');
    Route::get('/forgot-password', 'App\Http\Controllers\Auth\PasswordResetLinkController@create')->name('password.request');
    Route::post('/forgot-password', 'App\Http\Controllers\Auth\PasswordResetLinkController@store')->name('password.email');
    Route::get('/reset-password/{token}', 'App\Http\Controllers\Auth\NewPasswordController@create')->name('password.reset');
    Route::post('/reset-password', 'App\Http\Controllers\Auth\NewPasswordController@store')->name('password.store');

    Route::get('/auth/google/redirect', 'App\Http\Controllers\Auth\GoogleAuthController@redirect')->name('auth.google.redirect');
    Route::get('/auth/google/callback', 'App\Http\Controllers\Auth\GoogleAuthController@callback')->name('auth.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/verify-email', 'App\Http\Controllers\Auth\EmailVerificationPromptController@__invoke')->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', 'App\Http\Controllers\Auth\VerifyEmailController@__invoke')
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', 'App\Http\Controllers\Auth\EmailVerificationNotificationController@store')
        ->middleware('throttle:6,1')
        ->name('verification.send');
    Route::put('/password', 'App\Http\Controllers\Auth\PasswordController@update')->name('password.update');
    Route::post('/logout', 'App\Http\Controllers\Auth\AuthenticatedSessionController@destroy')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Regular User Area
|--------------------------------------------------------------------------
|
| Regular users stay on the public-facing site. Pending requests do not reduce
| item availability; that state change belongs in the staff approval action.
|
*/

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\User\DashboardController@index')->name('user.dashboard');
    Route::get('/borrow-requests', 'App\Http\Controllers\User\BorrowRequestController@index')->name('user.borrow-requests.index');
    Route::post('/items/{item}/borrow-requests', 'App\Http\Controllers\User\BorrowRequestController@store')->name('user.borrow-requests.store');
    Route::get('/notifications', 'App\Http\Controllers\User\NotificationController@index')->name('user.notifications.index');
    Route::patch('/notifications/{notification}/read', 'App\Http\Controllers\User\NotificationController@markAsRead')->name('user.notifications.read');
});

/*
|--------------------------------------------------------------------------
| Staff and Super Admin Dashboard
|--------------------------------------------------------------------------
|
| Staff can update item data and process borrowing workflow states. Super admin
| has the same access plus item creation/deletion and role management.
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:staff,super-admin'])
    ->group(function () {
        Route::get('/dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
        Route::get('/public-site', fn () => redirect()->route('home'))->name('public-site');

        Route::get('/items', 'App\Http\Controllers\Admin\ItemController@index')->name('items.index');
        Route::get('/items/{item}/edit', 'App\Http\Controllers\Admin\ItemController@edit')->name('items.edit');
        Route::patch('/items/{item}', 'App\Http\Controllers\Admin\ItemController@update')->name('items.update');

        Route::get('/borrow-requests', 'App\Http\Controllers\Admin\BorrowRequestController@index')->name('borrow-requests.index');
        Route::get('/borrow-requests/{borrowRequest}', 'App\Http\Controllers\Admin\BorrowRequestController@show')->name('borrow-requests.show');
        Route::patch('/borrow-requests/{borrowRequest}/approve', 'App\Http\Controllers\Admin\BorrowRequestController@approve')->name('borrow-requests.approve');
        Route::patch('/borrow-requests/{borrowRequest}/reject', 'App\Http\Controllers\Admin\BorrowRequestController@reject')->name('borrow-requests.reject');
        Route::patch('/borrow-requests/{borrowRequest}/return', 'App\Http\Controllers\Admin\BorrowRequestController@markAsReturned')->name('borrow-requests.return');

        Route::get('/notifications', 'App\Http\Controllers\Admin\NotificationController@index')->name('notifications.index');
        Route::patch('/notifications/{notification}/read', 'App\Http\Controllers\Admin\NotificationController@markAsRead')->name('notifications.read');

        Route::middleware('role:super-admin')->group(function () {
            Route::get('/items/create', 'App\Http\Controllers\Admin\ItemController@create')->name('items.create');
            Route::post('/items', 'App\Http\Controllers\Admin\ItemController@store')->name('items.store');
            Route::delete('/items/{item}', 'App\Http\Controllers\Admin\ItemController@destroy')->name('items.destroy');

            Route::get('/users', 'App\Http\Controllers\Admin\UserRoleController@index')->name('users.index');
            Route::patch('/users/{user}/role', 'App\Http\Controllers\Admin\UserRoleController@update')->name('users.role.update');
        });
    });
