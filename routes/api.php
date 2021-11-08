<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get_translations', [\App\Http\Controllers\TranslationController::class, 'index'])->name('get_translations');
    Route::post('import_strings', [\App\Http\Controllers\TextController::class, 'importStrings'])->name('import_strings');
    Route::post('import_from_laravel', [\App\Http\Controllers\TranslationController::class, 'importFromLaravel'])->name('import_from_laravel');
    Route::post('save_translations', [\App\Http\Controllers\TranslationController::class, 'saveTranslations'])->name('save_translations');

    Route::post('automatic_translation', [\App\Http\Controllers\TranslateService::class, 'translate'])->name('automatic_translation');
});
