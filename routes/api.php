<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use PHPUnit\Framework\Attributes\Group;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('profile', [AuthController::class,'profile'])->name('profile');
    Route::get('logout', [AuthController::class,'logout'])->name('logout');
});
