<?php

use catalyst\StarterKitRestApi\Http\Controllers\Auth\AuthController;
use catalyst\StarterKitRestApi\Http\Controllers\ProductController;
use catalyst\StarterKitRestApi\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/up', function () {
    return response()->json(['message' => 'Server is up and running!'], 200);
});


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt.auth')->group(function () {
    Route::get('user', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);
});
Route::apiResource('/products', ProductController::class);
