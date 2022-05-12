<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', '/contacts');

Auth::routes();

Route::group(['middelware' => ['auth']], function () {
    // Maak route voor ContactController 
    // Als user in zoekbalk contacts search gebruik ContactController
    Route::resource('contacts', 'App\Http\Controllers\ContactController');
    // Maak Route voor CompanyController 
    Route::resource('companies', 'App\Http\Controllers\CompanyController');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
