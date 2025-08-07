<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

use App\Models\ProductDetails;
use Illuminate\Http\Request;

use App\Http\Controllers\Backend\UserDetailsController;
use App\Http\Controllers\Backend\UserPermissionsController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\FeaturedProductsController;

use App\Http\Controllers\Frontend\HomeController;

// =========================================================================== Backend Routes

// Route::get('/', function () {
//     return view('frontend.index');
// });
  

// Authentication Routes
Route::get('/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::get('/change-password', [LoginController::class, 'change_password'])->name('admin.changepassword');
Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('admin.updatepassword');

Route::get('/register', [LoginController::class, 'register'])->name('admin.register');
Route::post('/register', [LoginController::class, 'authenticate_register'])->name('admin.register.authenticate');
    
// Admin Routes with Middleware
Route::group(['middleware' => ['auth:web', \App\Http\Middleware\PreventBackHistoryMiddleware::class]], function () {
        Route::get('/dashboard', function () {
            return view('backend.dashboard'); 
        })->name('admin.dashboard');
});

// ==== Manage Banner Details
Route::resource('manage-banner', BannerController::class);

// ==== Manage Featured Products
Route::resource('manage-featured-products', FeaturedProductsController::class);

// ==== Manage Contact Details
Route::resource('manage-contact', ContactController::class);


Route::group(['prefix'=> '', 'middleware'=>[\App\Http\Middleware\PreventBackHistoryMiddleware::class]],function(){

    // ==== Home
    Route::get('/', [HomeController::class, 'home'])->name('frontend.index');


});