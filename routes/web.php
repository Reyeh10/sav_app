<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\LogistiqueDashboardController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get(
        '/login',
        [LoginController::class, 'showLoginForm']
    )->name('login');

    Route::post(
        '/login',
        [LoginController::class, 'login']
    );

});


/*
|--------------------------------------------------------------------------
| DÉCONNEXION
|--------------------------------------------------------------------------
*/

Route::post(
    '/logout',
    [LoginController::class, 'logout']
)
    ->middleware([
        'auth',
        'nocache',
    ])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| CHANGEMENT OBLIGATOIRE DU MOT DE PASSE
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'nocache',
])->group(function () {

    Route::get(
        '/force-password',
        [UserController::class, 'forcePasswordForm']
    )->name('force.password.form');


    Route::post(
        '/force-password',
        [UserController::class, 'saveNewPassword']
    )->name('force.password.save');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $role = auth()->user()->role;

    return match ($role) {

        'admin' =>
            redirect()->route('dashboard.admindashboard'),

        'logistique' =>
            redirect()->route('dashboard.logistique'),

        'mecanicien' =>
            redirect()->route('vehicles.index'),

        'vendeur' =>
            redirect()->route('dashboard.vendor'),

        default =>
            redirect()->route('login'),
    };

})
    ->middleware([
        'auth',
        'nocache',
    ])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| DASHBOARD LOGISTIQUE
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'nocache',
    'role:logistique',
])->group(function () {

    Route::get(
        '/dashboard/logistique',
        [LogistiqueDashboardController::class, 'index']
    )->name('dashboard.logistique');

});


/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'nocache',
])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | EXPORT
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/vehicles/export-sold',
        [VehicleController::class, 'exportSold']
    )->name('vehicles.exportSold');


    Route::get(
        '/vehicles/export-vehicles',
        [VehicleController::class, 'exportVehicles']
    )->name('vehicles.exportVehicles');


    /*
    |--------------------------------------------------------------------------
    | VÉHICULES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/vehicles',
        [VehicleController::class, 'index']
    )
        ->middleware(
            'role:admin,logistique,mecanicien,vendeur'
        )
        ->name('vehicles.index');


    Route::get(
        '/vehicles-grid',
        [VehicleController::class, 'grid']
    )
        ->middleware(
            'role:admin,logistique,mecanicien,vendeur'
        )
        ->name('vehicles.grid');


    /*
    |--------------------------------------------------------------------------
    | CRÉATION VÉHICULE
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/vehicles/create',
        [VehicleController::class, 'create']
    )
        ->middleware(
            'role:admin,logistique'
        )
        ->name('vehicles.create');


    Route::post(
        '/vehicles',
        [VehicleController::class, 'store']
    )
        ->middleware(
            'role:admin,logistique'
        )
        ->name('vehicles.store');

    /*
    |--------------------------------------------------------------------------
    | AFFICHER UN VÉHICULE
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/vehicles/{vehicle}',
        [VehicleController::class, 'show']
    )
        ->middleware(
            'role:admin,logistique,mecanicien,vendeur'
        )
        ->name('vehicles.show');


    /*
    |--------------------------------------------------------------------------
    | VÉHICULES VENDUS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/vehicles-sold',
        [VehicleController::class, 'sold']
    )
        ->middleware(
            'role:admin,vendeur,mecanicien,logistique'
        )
        ->name('vehicles.sold');


    /*
    |--------------------------------------------------------------------------
    | MODIFICATION DU PRIX
    |--------------------------------------------------------------------------
    |
    | Le vendeur peut modifier le prix d'un véhicule.
    |
    */

    Route::get(
        '/vehicles/{vehicle}/edit-price',
        [VehicleController::class, 'editPrice']
    )
        ->middleware(
            'role:vendeur'
        )
        ->name('vehicles.editPrice');


    Route::put(
        '/vehicles/{vehicle}/update-price',
        [VehicleController::class, 'updatePrice']
    )
        ->middleware(
            'role:vendeur'
        )
        ->name('vehicles.updatePrice');


    /*
    |--------------------------------------------------------------------------
    | IMPORT VÉHICULES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/vehicles/import',
        [VehicleController::class, 'importForm']
    )
        ->middleware(
            'role:admin,logistique'
        )
        ->name('vehicles.import.form');


    Route::post(
        '/vehicles/import',
        [VehicleController::class, 'importExcel']
    )
        ->middleware(
            'role:admin,logistique'
        )
        ->name('vehicles.import');


    /*
    |--------------------------------------------------------------------------
    | INSPECTION VÉHICULE
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/vehicles/{vehicle}/inspection',
        [VehicleController::class, 'inspectionForm']
    )
        ->middleware(
            'role:admin,mecanicien'
        )
        ->name('vehicles.inspectionForm');


    Route::post(
        '/vehicles/{vehicle}/inspection',
        [VehicleController::class, 'updateInspectionStatus']
    )
        ->middleware(
            'role:admin,mecanicien'
        )
        ->name('vehicles.updateInspection');


    /*
    |--------------------------------------------------------------------------
    | MODIFICATION D'UN VÉHICULE
    |--------------------------------------------------------------------------
    |
    | Admin       : peut modifier le véhicule
    | Logistique  : peut modifier le véhicule
    | Mécanicien  : peut modifier le véhicule
    | Vendeur     : peut modifier le véhicule
    |
    */

    Route::get(
        '/vehicles/{vehicle}/edit',
        [VehicleController::class, 'edit']
    )
        ->middleware(
            'role:admin,logistique,mecanicien,vendeur'
        )
        ->name('vehicles.edit');


    Route::put(
        '/vehicles/{vehicle}',
        [VehicleController::class, 'update']
    )
        ->middleware(
            'role:admin,logistique,mecanicien,vendeur'
        )
        ->name('vehicles.update');

    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION VÉHICULE
    |--------------------------------------------------------------------------
    */

    Route::delete(
        '/vehicles/{vehicle}',
        [VehicleController::class, 'destroy']
    )
        ->middleware(
            'role:admin'
        )
        ->name('vehicles.destroy');


    /*
    |--------------------------------------------------------------------------
    | ADMIN + VENDEUR
    |--------------------------------------------------------------------------
    */

    Route::middleware(
        'role:admin,vendeur'
    )->group(function () {


        /*
        |--------------------------------------------------------------------------
        | PROFORMAS
        |--------------------------------------------------------------------------
        */

        Route::prefix('proformas')
            ->name('proformas.')
            ->controller(ProformaController::class)
            ->group(function () {


                /*
                |--------------------------------------------------------------------------
                | LISTE
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/',
                    'index'
                )->name('index');


                /*
                |--------------------------------------------------------------------------
                | CRÉATION
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/create',
                    'create'
                )->name('create');


                Route::get(
                    '/create/vehicle/{vehicle}',
                    'createWithVehicle'
                )->name('create.vehicle');


                Route::post(
                    '/',
                    'store'
                )->name('store');


                /*
                |--------------------------------------------------------------------------
                | MODIFICATION
                |--------------------------------------------------------------------------
                |
                | Ces routes permettent de modifier :
                |
                | - le prix HT du proforma
                | - la date de validité
                |
                */

                Route::get(
                    '/{proforma}/edit',
                    'edit'
                )->name('edit');


                Route::put(
                    '/{proforma}',
                    'update'
                )->name('update');


                /*
                |--------------------------------------------------------------------------
                | TÉLÉCHARGEMENT PDF
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/{proforma}/download',
                    'download'
                )->name('download');


                /*
                |--------------------------------------------------------------------------
                | TRANSFORMER PROFORMA EN VENTE
                |--------------------------------------------------------------------------
                */

                Route::post(
                    '/{proforma}/convert-to-sale',
                    'convertToSale'
                )->name('convert');


                /*
                |--------------------------------------------------------------------------
                | ANNULER PROFORMA
                |--------------------------------------------------------------------------
                */

                Route::post(
                    '/{proforma}/cancel',
                    'cancel'
                )->name('cancel');


                /*
                |--------------------------------------------------------------------------
                | AFFICHER PROFORMA
                |--------------------------------------------------------------------------
                |
                | Cette route dynamique reste après les routes spécifiques.
                |
                */

                Route::get(
                    '/{proforma}',
                    'show'
                )->name('show');

            });


        /*
        |--------------------------------------------------------------------------
        | VENTES
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | NOUVELLE VENTE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/sales/create',
            [SaleController::class, 'create']
        )->name('sales.create');


        /*
        |--------------------------------------------------------------------------
        | NOUVELLE VENTE AVEC VÉHICULE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/sales/create/{vehicle}',
            [SaleController::class, 'createWithVehicle']
        )->name('sales.create.withVehicle');


        /*
        |--------------------------------------------------------------------------
        | ENREGISTRER UNE VENTE
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/sales',
            [SaleController::class, 'store']
        )->name('sales.store');


        /*
        |--------------------------------------------------------------------------
        | LISTE DES FACTURES
        |--------------------------------------------------------------------------
        |
        | Cette route doit rester avant /sales/{sale}
        |
        */

        Route::get(
            '/sales-invoices',
            [SaleController::class, 'invoices']
        )->name('sales.invoices');


        /*
        |--------------------------------------------------------------------------
        | VÉHICULES APPROUVÉS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/vehicles-approved',
            [VehicleController::class, 'approved']
        )
            ->middleware(
                'role:admin,vendeur'
            )
            ->name('vehicles.approved');


        /*
        |--------------------------------------------------------------------------
        | FACTURE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/sales/{sale}/invoice',
            [SaleController::class, 'invoice']
        )->name('sales.invoice');


        /*
        |--------------------------------------------------------------------------
        | TÉLÉCHARGER FACTURE PDF
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/sales/{sale}/invoice/download',
            [SaleController::class, 'downloadInvoice']
        )->name('sales.invoice.download');


        /*
        |--------------------------------------------------------------------------
        | PAIEMENT FACTURE
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/sales/{sale}/invoice/pay',
            [SaleController::class, 'payInvoice']
        )->name('sales.invoice.pay');


        /*
        |--------------------------------------------------------------------------
        | ANNULATION FACTURE
        |--------------------------------------------------------------------------
        |
        | Seulement admin.
        |
        */

        Route::post(
            '/sales/{sale}/invoice/cancel',
            [SaleController::class, 'cancelInvoice']
        )
            ->middleware(
                'role:admin'
            )
            ->name('sales.invoice.cancel');


        /*
        |--------------------------------------------------------------------------
        | AFFICHER UNE VENTE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/sales/{sale}',
            [SaleController::class, 'show']
        )->name('sales.show');

    });


    /*
    |--------------------------------------------------------------------------
    | CRÉATION RAPIDE CLIENT
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/customers/quick-store',
        [CustomerController::class, 'quickStore']
    )
        ->middleware(
            'role:admin,vendeur'
        )
        ->name('customers.quickStore');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'nocache',
    'role:admin',
])->group(function () {

    Route::get(
        '/dashboard/admindashboard',
        [AdminDashboardController::class, 'index']
    )->name('dashboard.admindashboard');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD VENDEUR
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'nocache',
    'role:vendeur',
])->group(function () {

    Route::get(
        '/dashboard/vendor',
        [VendorDashboardController::class, 'index']
    )->name('dashboard.vendor');

});


/*
|--------------------------------------------------------------------------
| CLIENTS
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'nocache',
    'role:admin,vendeur',
])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | CRUD CLIENTS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'customers',
        CustomerController::class
    );


    /*
    |--------------------------------------------------------------------------
    | IMPORT CLIENTS
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/customers/import',
        [CustomerController::class, 'importExcel']
    )->name('customers.import');


    /*
    |--------------------------------------------------------------------------
    | EXPORT CLIENTS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/customers/export',
        [CustomerController::class, 'exportExcel']
    )->name('customers.export');

});


/*
|--------------------------------------------------------------------------
| GESTION DES UTILISATEURS
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'nocache',
    'role:admin',
])->group(function () {

    Route::resource(
        'users',
        UserController::class
    )->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ]);

});
