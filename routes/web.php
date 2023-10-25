<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/rekam-medis/store', 'RekamMedisController@store');
Route::get('/rekam-medis', 'RekamMedisController@index');
Route::get('/rekam-medis/pasien/{id}', 'RekamMedisController@riwayatPasien');
Route::get('/rekam-medis/dokter/{id}', 'RekamMedisController@rekamMedisDokter');


