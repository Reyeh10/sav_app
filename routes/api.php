<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    VehicleController,
    InspectionController,
    SaleController,
    WarrantyController,
    SavCaseController,
    MaintenanceTypeController,
    MaintenanceRecordController,
    MaintenanceReminderController
};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::middleware('auth:sanctum')->group(function () {

    /* =======================
       VEHICLES
    ======================= */
    Route::apiResource('vehicles', VehicleController::class);

    /* =======================
       INSPECTIONS
    ======================= */
    Route::post('inspections', [InspectionController::class, 'store']);

    /* =======================
       SALES & WARRANTY
    ======================= */
    Route::post('sales', [SaleController::class, 'store']);
    Route::get(
        'vehicles/{vehicle}/warranty',
        [WarrantyController::class, 'showByVehicle']
    );

    /* =======================
       SAV CASES
    ======================= */
    Route::get('sav-cases', [SavCaseController::class, 'index']);
    Route::post('sav-cases', [SavCaseController::class, 'store']);

    Route::post(
        'sav-cases/{savCase}/approve',
        [SavCaseController::class, 'approve']
    );

    Route::post(
        'sav-cases/{savCase}/reject',
        [SavCaseController::class, 'reject']
    );

    /* =======================
       MAINTENANCE
    ======================= */
    Route::apiResource(
        'maintenance-types',
        MaintenanceTypeController::class
    )->only(['index', 'store']);

    Route::post(
        'maintenance-records',
        [MaintenanceRecordController::class, 'store']
    );

    /*Route::post(
        'maintenance-reminders',
        [MaintenanceReminderController::class, 'store']
    );*/
});

