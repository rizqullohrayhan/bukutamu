<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CategoryDescriptionController;
use App\Http\Controllers\GuestsController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\SuratController;
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
Route::get('/', function (){
    return redirect('/guestbook');
});

Route::resource('/guestbook', GuestBookController::class);
Route::post('/export-data', [GuestBookController::class, 'exportData'])->name('export');

Route::resource('/guests', GuestsController::class);
Route::get('/guest-activity', [GuestsController::class, 'guestHistory']);

Route::resource('/surat', SuratController::class);
Route::post('/surat/export', [SuratController::class, 'exportData'])->name('surat_export');

Route::resource('/problems', CategoryDescriptionController::class);

Route::get('/analytics', [AnalyticsController::class, 'index']);
Route::get('/analytics/{group_by}', [AnalyticsController::class, 'categoryAnalytics']);

Route::get('/welcome', function()
{
    return view('welcome');
});