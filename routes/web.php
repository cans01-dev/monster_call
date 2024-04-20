<?php

use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EndingController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ForbiddenListController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TelListController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'pages.login')->name('login');
    
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {    
    Route::redirect('/', '/home');

    Route::get('/home', [Controller::class, 'home']);
    
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('users', UserController::class)->only(['show', 'update']);

    Route::prefix('/users/{user}')->controller(UserController::class)->group(function () {
        Route::put('/password', 'update_password');
        Route::post('/surveys', [SurveyController::class, 'store']);
        Route::post('/send_emails', [SendEmailController::class, 'store']);
    });

    Route::resource('send_emails', SendEmailController::class)->only(['update', 'destroy']);

    Route::resource('surveys', SurveyController::class)->only(['show', 'update']);

    Route::prefix('/surveys/{survey}')->controller(SurveyController::class)->group(function () {
        Route::get('/stats', 'stats');
        Route::get('/stats/areas/{area}', 'stats_area');
        Route::get('/asset', 'asset');
        Route::post('/greeting', 'update_greeting');
        Route::get('/reservations/{year?}/{month?}/{mode?}', [ReservationController::class, 'index']);
        Route::post('all_voice_file_re_gen', 'all_voice_file_re_gen');
        Route::get('/calls', [CallController::class, 'index']);
        Route::post('/reservations', [ReservationController::class, 'store']);
        Route::post('/favorites', [FavoriteController::class, 'store']);
        Route::post('/areas', [AreaController::class, 'store']);
        Route::post('/tel_lists', [TelListController::class, 'store']);
        Route::get('/forbidden_lists', [ForbiddenListController::class, 'index']);
        Route::post('/forbidden_lists', [ForbiddenListController::class, 'store']);
        Route::post('/endings', [EndingController::class, 'store']);
        Route::post('/faqs', [FaqController::class, 'store']);
    });

    Route::resource('endings', EndingController::class)->only(['update', 'destroy']);

    Route::resource('faqs', FaqController::class)->only(['show', 'update', 'destroy']);
    Route::post('/faqs/{faq}/options', [OptionController::class, 'store']);
    Route::post('/faqs/{faq}/order', [FaqController::class, 'order']);

    Route::resource('options', OptionController::class)->only(['update', 'destroy']);
    Route::post('/options/{option}/change_order', [OptionController::class, 'change_order']);

    Route::resource('reservations', ReservationController::class)->only(['show', 'update', 'destroy']);

    Route::prefix('/reservations/{reservation}')->controller(ReservationController::class)->group(function () {
        Route::post('/attach_area', 'attach_area');
        Route::post('/detach_area', 'detach_area');
    });

    Route::resource('favorites', FavoriteController::class)->only(['show', 'update', 'destroy']);

    Route::prefix('/favorites/{favorite}')->controller(FavoriteController::class)->group(function () {
        Route::post('/attach_area', 'attach_area');
        Route::post('/detach_area', 'detach_area');
    });

    Route::resource('areas', AreaController::class)->only(['show', 'update', 'destroy']);

    Route::post('/areas/{area}/stations', [StationController::class, 'store']);

    Route::resource('tel_lists', TelListController::class)->only(['show', 'update', 'destroy']);

    Route::prefix('/tel_lists/{tel_list}')->controller(TelListController::class)->group(function () {
        Route::post('/tels', 'store_tel');
        Route::post('/import_csv', 'import_csv');
    });

    Route::resource('forbidden_lists', ForbiddenListController::class)->only(['show', 'update', 'destroy']);
    Route::prefix('/forbidden_lists/{forbidden_list}')->controller(ForbiddenListController::class)->group(function () {
        Route::post('/tels', 'store_tel');
        Route::post('/import_csv', 'import_csv');
    });

    Route::resource('stations', StationController::class)->only(['destroy']);

    Route::resource('calls', CallController::class)->only(['show']);
    
    Route::get('/support', [Controller::class, 'support']);

    Route::post('/support/contact', [Controller::class, 'send_contact']);
});

Route::middleware(['admin'])->prefix('/admin')->group(function () {
    Route::resource('users', AdminUserController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::prefix('/users/{user}')->controller(AdminUserController::class)->group(function () {
        Route::post('/password', 'update_password');
        Route::post('/clean_dir', 'clean_dir');
    });

    Route::resource('reservations', AdminReservationController::class)->only(['index']);

    Route::prefix('/reservations/{reservation}')->controller(AdminReservationController::class)->group(function () {
        Route::post('/forward_confirmed', 'forward_confirmed');
        Route::post('/back_reservationd', 'back_reservationd');
        Route::post('/forward_collected', 'forward_collected');
        Route::post('/back_confirmed', 'back_confirmed');
        Route::post('/delete_calls', 'delete_calls');
        Route::post('/generate_sample_result', 'generate_sample_result');
    });
});
