<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomRentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;
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

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/login-only-password/{id}', [WelcomeController::class, 'loginOnlyPassword']);



Route::post('/send-message', [TelegramController::class, 'sendMessage']);
Route::get('/get-username', [TelegramController::class, 'getUsernameByPhoneNumber']);

Auth::routes([
    'register' => false,
]);

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('/room', RoomController::class);
    Route::resource('/room-rent', RoomRentController::class);

    Route::resource('/message', MessageController::class);
    Route::get('/message/destroy/{id}', [MessageController::class, 'messageDestroy']);
    Route::get('/send-message/{id}', [MessageController::class, 'sendMessage']);
    Route::post('/send-message-all', [MessageController::class, 'sendMessageAll']);
    Route::get('send-message-list/{id}', [MessageController::class, 'messageList']);

    Route::resource('/invoice', InvoiceController::class);
    Route::get('/invoice-search', [InvoiceController::class, 'invoiceSearch']);
    Route::get('/invoice/destroy/{id}', [InvoiceController::class, 'invoiceDestroy']);
    Route::get('/invoice/pay/{id}', [InvoiceController::class, 'pay']);
    Route::get('/invoice/print/{id}', [InvoiceController::class, 'print']);
    Route::get('/invoice/screenshot/{id}', [InvoiceController::class, 'screenshot']);
    Route::post('/invoice-base64-to-image', [InvoiceController::class, 'saveScreenshot']);
    Route::get('/invoice/send/{id}', [InvoiceController::class, 'send']);
    Route::post('/invoice/send-all', [InvoiceController::class, 'sendAll']);

    Route::resource('/user', UserController::class);
    Route::get('/change-apartment/{id}', [UserController::class, 'changeApartment']);
    Route::get('/user/status/{id}', [UserController::class, 'userStatus']);
    Route::get('/user/destroy/{id}', [UserController::class, 'userDestroy']);
    Route::get('/user/change-password/{id}', [UserController::class, 'changePassword']);
    Route::post('/user/update-password/{id}', [UserController::class, 'updatePassword']);

    Route::resource('/apartment', ApartmentController::class);
    Route::get('/water-module/{id}',[App\Http\Controllers\ApartmentController::class, 'waterModule']);
});
