<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DecrypterController;
use App\Http\Controllers\EncrypterController;
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

Route::get('', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/encrypter', [EncrypterController::class, 'encrypter'])->name('encrypter');
Route::get('/decrypter', [DecrypterController::class, 'decrypter'])->name('decrypter');

Route::post('/encrypter/symetrical', [EncrypterController::class, 'symmetricEncrypt'])->name('symmetricEncrypt');
Route::post('/encrypter/asymetrical', [EncrypterController::class, 'asymmetricEncrypt'])->name('asymmetricEncrypt');

Route::post('/decrypter/symetrical', [DecrypterController::class, 'symmetricDecrypter'])->name('symmetricDecrypter');
Route::post('/decrypter/asymetrical', [DecrypterController::class, 'asymmetricDecrypter'])->name('asymmetricDecrypter');