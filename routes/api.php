<?php

use App\Http\Controllers\UserAPIController;
use Illuminate\Support\Facades\Route;

Route::apiResource('user', UserAPIController::class);