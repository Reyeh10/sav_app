<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\LogistiqueDashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware(['auth','nocache'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| FORCE PASSWORD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','nocache'])->group(function () {

    Route::get('/force-password', [UserController::class, 'forcePasswordForm'])
        ->name('force.password.form');

    Route::post('/force-password', [UserController::class, 'saveNewPassword'])
        ->name('force.password.save');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $role = auth()->user()->role;

    return match ($role) {
        'admin'      => redirect()->route('dashboard.admindashboard'),
        'logistique' => redirect()->route('dashboard.logistique'),
        'mecanicien' => redirect()->route('vehicles.index'),
        'vendeur'    => redirect()->route('dashboard.vendor'),
        default      => redirect()->route('login'),
    };

})->middleware(['auth','nocache'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| LOGISTIQUE DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','nocache','role:logistique'])->group(function () {

    Route::get('/dashboard/logistique', [LogistiqueDashboardController::class, 'index'])
        ->name('dashboard.logistique');
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','nocache'])->group(function () {

    /*
    ================= VEHICLES =================
    */

    Route::get('/vehicles', [VehicleController::class, 'index'])
        ->middleware('role:admin,logistique,mecanicien,vendeur')
        ->name('vehicles.index');

    Route::get('/vehicles-grid', [VehicleController::class, 'grid'])
        ->middleware('role:admin,logistique,mecanicien,vendeur')
        ->name('vehicles.grid');

    Route::get('/vehicles/create', [VehicleController::class, 'create'])
        ->middleware('role:admin,logistique')
        ->name('vehicles.create');

    Route::post('/vehicles', [VehicleController::class, 'store'])
        ->middleware('role:admin,logistique')
        ->name('vehicles.store');

    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])
        ->middleware('role:admin,logistique,mecanicien,vendeur')
        ->name('vehicles.show');

    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])
        ->middleware('role:admin,logistique,mecanicien')
        ->name('vehicles.edit');

    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])
        ->middleware('role:admin,logistique,mecanicien')
        ->name('vehicles.update');

    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('vehicles.destroy');

    Route::get('/vehicles-sold', [VehicleController::class, 'sold'])
        ->middleware('role:admin,vendeur,mecanicien,logistique')
        ->name('vehicles.sold');

    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])
    ->middleware('role:admin,vendeur,mecanicien,logistique')
    ->name('vehicles.show');
    /*
    ================= UPDATE PRICE (FIXED POSITION) =================
    */

    Route::get('/vehicles/{vehicle}/edit-price', [VehicleController::class, 'editPrice'])
    ->middleware(['auth','role:vendeur'])
    ->name('vehicles.editPrice');

    Route::put('/vehicles/{vehicle}/update-price', [VehicleController::class, 'updatePrice'])
    ->middleware(['auth','role:vendeur'])
    ->name('vehicles.updatePrice');

    /*
    ================= IMPORT =================
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

    Route::get('/sales/create/', [SaleController::class, 'create'])
        ->middleware('role:admin,vendeur')
        ->name('sales.create');

    Route::get('/sales/create/{vehicle}', [SaleController::class, 'createWithVehicle'])
    ->name('sales.create.withVehicle');

    // Route pour bouton "Vendre" avec ID
    Route::post('/sales', [SaleController::class, 'store'])
        ->middleware('role:admin,vendeur')
        ->name('sales.store');

    Route::get('/vehicles-approved', [VehicleController::class, 'approved'])
        ->middleware('role:admin,vendeur')
        ->name('vehicles.approved');

    /*
    ================= QUICK CUSTOMER =================
    */

    Route::post('/customers/quick-store', [CustomerController::class, 'quickStore'])
        ->middleware('role:admin,vendeur')
        ->name('customers.quickStore');
});

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','nocache','role:admin'])->group(function () {

    /* Route::get('/dashboard/admindashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard.admindashboard'); */
        Route::get('/dashboard/admindashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth','role:admin'])
    ->name('dashboard.admindashboard');
});

/*
|--------------------------------------------------------------------------
| VENDEUR DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','nocache','role:vendeur'])->group(function () {

    Route::get('/dashboard/vendor', [VendorDashboardController::class, 'index'])
        ->name('dashboard.vendor');
});

/*
|--------------------------------------------------------------------------
| CUSTOMERS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','nocache','role:admin,vendeur'])->group(function () {

    Route::resource('customers', CustomerController::class);

    Route::post('/customers/import', [CustomerController::class, 'importExcel'])
        ->name('customers.import');

    Route::get('/customers/export', [CustomerController::class, 'exportExcel'])
        ->name('customers.export');
});

/*
|--------------------------------------------------------------------------
| USERS MANAGEMENT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','nocache','role:admin'])->group(function () {

    Route::resource('users', UserController::class)
        ->only(['index','create','store','edit','update','destroy']);
});
