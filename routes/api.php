<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController;
use App\Models\ProductColor;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("insert_cate",[ApiController::class,"insertCategory"]);
Route::post("insert_country",[ApiController::class,"insertCountry"]);
Route::post("insert_subcate",[ApiController::class,"insertSubcategory"]);
Route::post("insert_product",[ApiController::class,"insertProduct"]);
Route::post("update_pro_size/{cate_id}/{sub_id}/{prod_id}",[ApiController::class,"insertNewColor"]);
Route::get("update_pro_size/{id}/{sub_id}",[ApiController::class,"updateMakeup"]);

Route::get('getallpro',[ProductController::class,"productSearchApi"]);