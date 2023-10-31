<?php

namespace parzival42codes\LaravelCodeOptimize;

use Illuminate\Support\Facades\Route;
use parzival42codes\LaravelCodeOptimize\App\Http\Controllers\DashboardController;

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

Route::middleware(['web', 'auth'])
    ->group(function () {
        Route::get('code-optimize', [DashboardController::class, 'index'])
            ->name('code-optimize.dashboard');
    });
