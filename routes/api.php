<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('get-service-menus',[ApiController::class,'getServiceMenus']);
//Route::get('get-menu-services/{id}',[ApiController::class,'getMenuServices']);

Route::get('get-service/{id}',[ApiController::class,'getService']);
Route::get('get-services',[ApiController::class,'getServices']);

Route::get('get-slider',[ApiController::class,'getSlider']);

Route::get('get-product/{id}',[ApiController::class,'getProduct']);
Route::get('get-products',[ApiController::class,'getProducts']);

Route::get('get-about',[ApiController::class,'getAbout']);
Route::get('get-home-about',[ApiController::class,'getHomeAbout']);

Route::get('get-home-client',[ApiController::class,'getHomClient']);

Route::get('get-news',[ApiController::class,'getNews']);
Route::get('get-event',[ApiController::class,'getEvent']);

Route::get('get-blog/{id}',[ApiController::class,'getBlog']);

Route::get('get-gallery',[ApiController::class,'getGallery']);

Route::get('get-info',[ApiController::class,'getInfo']);
