<?php

use App\Http\Controllers\ComercialController;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

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
})->name('index');

Route::get('/financiero', function () {
    return view('welcome');
})->name('financiero');

Route::get('/agence', function () {
    return view('welcome');
})->name('agence');

Route::get('/projectos', function () {
    return view('welcome');
})->name('projectos');

Route::get('/administrativo', function () {
    return view('welcome');
})->name('administrativo');

Route::get('/usuario', function () {
    return view('welcome');
})->name('usuario');

Route::post('/relatorio', function ($type) {
    return response()->json([
//        ['periodo' => Carbon::create(rand($request->)),'name' => 'Abigail',],
        ['id' => 3,'name' => 'Taylor',]
    ]);
})->name('relatorio');

Route::controller(ComercialController::class)->prefix('comercial')->group(function (){
    Route::get('/','index')->name('comercial');
    Route::get('/performance', 'performance')->name('comercial.performance');
    Route::get('/relatorio', 'getSubjects')->name('comercial.relatorio');
});



