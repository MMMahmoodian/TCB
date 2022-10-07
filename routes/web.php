<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',             [Controller::class, "index"]);
Route::get('/bulk-block',   [Controller::class, "bulkBlock"])->name("bulk-block");

Route::get('/twitter-v2-auth', [AuthController::class, "v2OauthCallback"])->name("v2-oauth-callback");
Route::get('/twitter-v1-auth', [AuthController::class, "v1OauthCallback"])->name("v1-oauth-callback");
