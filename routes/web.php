<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlannerController;

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

Route::get('/', [DashboardController::class, 'data'])->name('dashboard');
Route::get('/planner', [PlannerController::class, 'data'])->name('planner');
Route::view('/help', 'help')->name('help');

Route::post('/planner/setfavorite', [PlannerController::class, 'setFavorite']);
Route::post('/planner/savenote', [PlannerController::class, 'saveNote']);