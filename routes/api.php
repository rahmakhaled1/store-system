<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\GovernorateController;
use App\Http\Controllers\Dashboard\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Admin Route
Route::group([
    "prefix" => "dashboard/v1/",
    "middleware" => ["auth:sanctum"]
],
    function (){
        /* Start Governorate */
        Route::post("fetch_governorate",[GovernorateController::class, "fetch_governorate"]);
        Route::post("store_governorate",[GovernorateController::class, "store_governorate"]);
        Route::post("show_governorate",[GovernorateController::class, "show_governorate"]);
        Route::post("update_governorate",[GovernorateController::class, "update_governorate"]);
        Route::post("delete_governorate",[GovernorateController::class, "delete_governorate"]);
        /* End Governorate */

        /* Start Setting */
        Route::post("fetch_setting",[SettingController::class, "fetch_setting"]);
        Route::post("store_setting",[SettingController::class, "store_setting"]);
        Route::post("show_setting",[SettingController::class, "show_setting"]);
        Route::post("update_setting",[SettingController::class, "update_setting"]);
        Route::post("delete_setting",[SettingController::class, "delete_setting"]);
        /* End Setting */

});

/* Start Login */
Route::post("dashboard/v1/login",[AuthController::class, "login"])->name("login");
/* End Login */
