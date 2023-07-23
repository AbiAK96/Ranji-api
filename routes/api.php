<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\Admin\AdminController;
use App\Http\Controllers\API\V1\Admin\ServiceCategoryController;
use App\Http\Controllers\API\V1\Admin\ServiceController;
use App\Http\Controllers\API\V1\Customer\JobController;
use App\Http\Controllers\API\V1\Customer\PaymentController;
use App\Http\Controllers\API\V1\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\API\V1\Admin\JobController as AdminJobController;
use App\Http\Controllers\API\V1\Customer\ProvideServiceController;
use App\Http\Controllers\API\V1\Admin\ProvideServiceController as AdminProvideServiceController;
use App\Http\Controllers\API\V1\Customer\VacancyController;
use App\Http\Controllers\API\V1\Admin\VacancyController as AdminVacancyController;
use App\Http\Controllers\API\V1\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {

        Route::prefix('/admin')->group(function () {
            Route::middleware(['auth:sanctum'])->group(function(){ 
                Route::put('/update-profile', [AdminController::class, 'updateProfile']);
                Route::get('/current-user', [AdminController::class, 'currentUser']);
                Route::post('/change-password', [AdminController::class, 'changePassword']);
                Route::post('/logout', [AdminController::class, 'logout']);

                Route::resource('service-category', ServiceCategoryController::class);
                Route::resource('service', ServiceController::class);
                Route::resource('job', AdminJobController::class);
                Route::resource('provide-service', AdminProvideServiceController::class);
                Route::resource('vacancy', AdminVacancyController::class);
                Route::post('job-payment/{id}', [AdminPaymentController::class, 'makePayment']);
                
            });
            Route::post('/login', [AdminController::class, 'login']);
        });

        Route::prefix('/customer')->group(function () {
            Route::middleware(['auth:sanctum'])->group(function(){ 
                Route::resource('job', JobController::class);
                Route::post('job-payment/{id}', [PaymentController::class, 'makePayment']);
                Route::resource('provide-service', ProvideServiceController::class);
                Route::resource('vacancy', VacancyController::class);
            });

            Route::post('/registration', [UserController::class, 'customerRegistration']);

        });

        Route::middleware(['auth:sanctum'])->group(function(){ 
            Route::put('/update-profile', [UserController::class, 'updateProfile']);
            Route::get('/current-user', [UserController::class, 'currentUser']);
            Route::post('/change-password', [UserController::class, 'changePassword']);
            Route::post('/logout', [UserController::class, 'logout']);
            Route::post('/upload-profile', [UserController::class, 'uploadProfileImage']);

            Route::get('chat/{id}', [ChatController::class, 'getChat']);
            Route::post('chat/{id}', [ChatController::class, 'saveChat']);
            Route::get('chat', [ChatController::class, 'getAllChat']);
        });

        Route::post('/login', [UserController::class, 'login']);
        Route::post('/forgot-password', [UserController::class, 'forgotPassword']);

    Route::get('/test', [UserController::class, 'testFunction']);
    
});
