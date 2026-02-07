<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\VendorDashboardController;


/*
|--------------------------------------------------------------------------
AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
DASHBOARD REDIRECT BY ROLE
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $role = auth()->user()->role;

    return match ($role) {
        'admin'      => redirect()->route('dashboard.admindashboard'),
        'logistique' => redirect()->route('vehicles.index'),
        'mecanicien' => redirect()->route('vehicles.index'),
        'vendeur'    => redirect()->route('dashboard.vendor'),
        default      => redirect()->route('login'),
    };

})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    ==================================================
    VEHICLES
    ==================================================
    */

    Route::get('/vehicles', [VehicleController::class, 'index'])
        ->middleware('role:admin,logistique,mecanicien,vendeur')
        ->name('vehicles.index');

    Route::get('/vehicles-grid', [VehicleController::class, 'grid'])
        ->middleware('role:admin,logistique,mecanicien,vendeur')
        ->name('vehicles.grid');

    /*
    ================= CREATE / STORE =================
    */

    Route::get('/vehicles/create', [VehicleController::class, 'create'])
        ->middleware('role:admin,logistique')
        ->name('vehicles.create');

    Route::post('/vehicles', [VehicleController::class, 'store'])
        ->middleware('role:admin,logistique')
        ->name('vehicles.store');

    /*
    ================= SHOW =================
    */

    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])
        ->middleware('role:admin,logistique,mecanicien,vendeur')
        ->name('vehicles.show');

    /*
    ================= EDIT / UPDATE =================
    */

    /* Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])
        ->middleware('role:admin,logistique,mecanicien')
        ->name('vehicles.edit');

    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])
        ->middleware('role:admin,logistique,mecanicien')
        ->name('vehicles.update'); */
        Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])
            ->middleware('role:admin,logistique,mecanicien,vendeur')
            ->name('vehicles.edit');

        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])
            ->middleware('role:admin,logistique,mecanicien,vendeur')
            ->name('vehicles.update');


         /*
    ================= voiture vendu =================
    */
    Route::get('/vehicles-sold', [VehicleController::class, 'sold'])
    ->middleware('role:admin,vendeur')
    ->name('vehicles.sold');


    /*
    ================= IMPORT EXCEL =================
    */

    Route::get('/vehicles/import', [VehicleController::class, 'importForm'])
        ->middleware('role:admin,logistique')
        ->name('vehicles.import.form');

    Route::post('/vehicles/import', [VehicleController::class, 'importExcel'])
        ->middleware('role:admin,logistique')
        ->name('vehicles.import');

    /*
    ================= INSPECTION =================
    */

    Route::get('/vehicles/{vehicle}/inspection', [VehicleController::class, 'inspectionForm'])
        ->middleware('role:admin,mecanicien')
        ->name('vehicles.inspectionForm');

    Route::post('/vehicles/{vehicle}/inspection', [VehicleController::class, 'updateInspectionStatus'])
        ->middleware('role:admin,mecanicien')
        ->name('vehicles.updateInspection');

    /*
    ================= SALES =================
    */

    Route::get('/sales/create', [SaleController::class, 'create'])
        ->middleware('role:admin,vendeur')
        ->name('sales.create');

    Route::post('/sales', [SaleController::class, 'store'])
        ->middleware('role:admin,vendeur')
        ->name('sales.store');

    Route::get('/vehicles-approved', [VehicleController::class, 'approved'])
        ->middleware('role:admin,vendeur')
        ->name('vehicles.approved');

    /*
    ================= DELETE =================
    */

    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('vehicles.destroy');
});

/*
|--------------------------------------------------------------------------
ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard/admindashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard.admindashboard');
});

/*
|--------------------------------------------------------------------------
VENDEUR DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:vendeur'])->group(function () {

    Route::get('/dashboard/vendor', [VendorDashboardController::class, 'index'])
        ->name('dashboard.vendor');
});


/*
|--------------------------------------------------------------------------
CUSTOMERS
|--------------------------------------------------------------------------
*/

Route::resource('customers', CustomerController::class)
    ->middleware('role:admin,vendeur');

Route::post('/customers/import', [CustomerController::class, 'importExcel'])
    ->middleware('role:admin,vendeur')
    ->name('customers.import');

Route::get('/customers/export', [CustomerController::class, 'exportExcel'])
    ->middleware('role:admin,vendeur')
    ->name('customers.export');
