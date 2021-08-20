<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\SaleController;
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

Route::get('/foo', function () {
  Artisan::call('storage:link');
});

//Import Excel Data
Route::get('import-customers', [ImportController::class, 'customers_import']);
Route::get('import-sales', [ImportController::class, 'sales_import']);
Route::get('import-products', [ImportController::class, 'products_import']);
Route::get('import-employees', [ImportController::class, 'employees_import']);

Auth::routes();

/* Route Dashboards */
Route::middleware('auth')->group(function () {
  
  // Main Page Route
  Route::get('/', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard');
  Route::get('dashboard', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard');
  
  /* Route Sales History */
  Route::group(['prefix' => 'sales-data'], function () {
    Route::get('/', [DashboardController::class, 'sales_data'])->name('sales_data');
  });
  /* Route Sales History */

  /* Route Settings */
  Route::group(['prefix' => 'page'], function () {
    Route::get('/account-settings', [SettingsController::class, 'index'])->name('account_settings');
    Route::post('imgae-upload', [SettingsController::class, 'upload'])->name('profile.update');
    Route::post('user-general-update', [SettingsController::class, 'user_general_update']);
    Route::post('user-password-update', [SettingsController::class, 'user_password_update']);
  });
  /* Route Settings */

  /* Route Sales */
  Route::group(['prefix' => 'data-grid'], function () {
    Route::get('/', [SaleController::class, 'index'])->name('data-grid');
    Route::get('sales-list', [SaleController::class, 'sales_list']);
    Route::post('sale/create', [SaleController::class, 'store']);
    Route::delete('sale/{sale}', [SaleController::class, 'destroy']);
    Route::get('sale/{sale}/edit', [SaleController::class, 'edit']);
    Route::post('sale/{sale}/update', [SaleController::class, 'update']);
  });
  /* Route Sales */

});
/* Route Dashboards */

/* Route Pages */
Route::get('/error', 'MiscellaneousController@error')->name('error');

