<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeContoller;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeContoller::class,'index'])->name('front.home');

Route::group(['prefix' => 'account'],function(){

    //Guest Routes
    Route::group(['middleware' => 'guest'],function(){

        Route::get('/register',[AccountController::class,'registration'])->name('account.registration');
        Route::post('/process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
        Route::get('/login',[AccountController::class,'login'])->name('account.login');
        Route::post('/authienticate',[AccountController::class,'authienticate'])->name('account.authienticate');

    });

    //Authenticated Routes
    Route::group(['middleware' => 'auth'],function(){

        Route::get('/profile',[AccountController::class,'profile'])->name('account.profile');
        Route::get('/logout',[AccountController::class,'logout'])->name('account.logout');

    });
});