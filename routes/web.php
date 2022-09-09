<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
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

Route::get('/', [ListingController::class,'index']);

//Show Creat Form
Route::get('listings/create',[ListingController::class,'create'])->middleware('auth');

//Store Listing data
Route::post('listings',[ListingController::class,'store'])->middleware('auth');

//Show Edit Form
Route::get('listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//Edit Submit to update
Route::put('listings/{listing}',[ListingController::class,'update'])->middleware('auth');

//Delete Listing
Route::delete('listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');

//Manage Listings
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');

//single listing
Route::get('listings/{listing}',[ListingController::class,'show']);

//Show Register/Create Form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

//Store Users
Route::post('/users',[UserController::class,'store']);

//Log User Out
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

//Show Login Form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//Log User In 
Route::post('/users/authenticate',[UserController::class,'authenticate']);
