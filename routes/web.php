<?php

use App\Http\Controllers\HomeContoller;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeContoller::class,'index'])->name('front.home');
