<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/greeting', function () {
    return 'Hello, World!';
});

Route::get('/users', function () {
    return User::all();
});