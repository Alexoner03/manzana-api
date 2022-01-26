<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('user',[UserController::class,'store'])->name("user.store");
Route::post('user/login',[UserController::class,'login'])->name("user.login");

Route::middleware("api")->group(function(){
    Route::put('user/food',[UserController::class,"addFood"])->name('user.addFood');
    Route::delete('user/food',[UserController::class,"removeFood"])->name('user.removeFood');
    Route::get('/user/me',[UserController::class,"me"])->name("user.me");

    Route::get('foods',[FoodController::class,'index'])->name("food.index");
});
