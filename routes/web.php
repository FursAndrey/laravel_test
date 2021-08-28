<?php
use Illuminate\Support\Facades\Route;

use App\Http\Logic\ReferenceLogic;

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
    return view('home');
})->name('home');

Route::get('/calc', function () {
    return view('calc_form', ['typesEO' => ReferenceLogic::getListTypeEO()]);
})->name('calc-form');

Route::post('/calc/start', 'CalcController@submit')->name('calc-start');