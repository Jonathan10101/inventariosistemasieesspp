<?php


use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\CocinaController;
use App\Http\Controllers\Admin\HomeController;



//Route::apiResource('cocina', CocinaController::class);
Route::get("",[HomeController::class,'index']);
