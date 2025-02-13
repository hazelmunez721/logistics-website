<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as FrontendController;
use App\Http\Controllers\Backend as BackendController;

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

Route::controller(FrontendController\PageController::class)->group(function() {
    Route::get('', 'home')->name('home');
    Route::get('about-us', 'aboutUs')->name('about-us');
    Route::get('our-services', 'ourServices')->name('our-services');
    Route::get('faqs', 'faqs')->name('faqs');
    Route::get('blogs', 'blogs')->name('blogs');
    Route::get('blogs-single', 'blogsSingle')->name('blogs-single');
    Route::get('contact-us', 'contactUs')->name('contact-us');
    Route::get('track', 'trackPackage')->name('track');
    Route::get('register', 'register')->name('register');
    Route::post('inquiry', 'inquiry')->name('inquiry');
});

Route::controller(FrontendController\AuthController::class)->group(function() {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'signIn');
    Route::post('register', 'register');
});

Route::middleware(['user-access:user'])->group(function() {
    Route::post('logout', [ FrontendController\AuthController::class, 'logout' ]);

    Route::controller(FrontendController\CustomerController::class)->group(function() {
        Route::get('dashboard', 'dashboard');
        Route::get('create-order', 'createOrder');
        Route::get('order-status', 'orderStatus');
        Route::get('shipment-tracking', 'shipmentTracking');
        Route::get('order-history', 'orderHistory');
        Route::get('address-book', 'addressBook');
        Route::get('personal-profile', 'personalProfile');
        Route::post('order-submit', 'order');
    });

});

Route::prefix('admin')->group(function() {
    Route::get('login', [ BackendController\AuthController::class, 'login' ])->name('admin.login');
    Route::post('login', [ BackendController\AuthController::class, 'signIn' ]);

    Route::middleware(['user-access:admin'])->group(function() {
        Route::post('logout', [ BackendController\AuthController::class, 'logout' ]);

        Route::controller(BackendController\AdminController::class)->group(function() {
            Route::get('dashboard', 'dashboard');
            Route::get('order-management', 'orderManagement');
            Route::get('customer-management', 'customerManagement');
            Route::get('drive-and-delivery-personnel-management', 'driveAndDeliveryPersonnelManagement');
            Route::get('settings-and-configuration', 'settingsAndConfiguration');

            Route::get('inquiry', 'inquiry');
            Route::delete('inquiry/{id}', 'inquiryDelete');
            Route::get('inquiry/export', 'inquiryExport');

            Route::get('trash/inquiry', 'trashInquiry');
            Route::post('trash/inquiry/retrieve', 'inquiryRetrieve');
        });
        
    });
});