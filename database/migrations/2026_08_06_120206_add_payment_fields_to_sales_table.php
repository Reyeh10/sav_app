<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | paid_amount
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('sales', 'paid_amount')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->decimal('paid_amount', 15, 2)
                    ->default(0);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | remaining_amount
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('sales', 'remaining_amount')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->decimal('remaining_amount', 15, 2)
                    ->default(0);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | paid_at
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('sales', 'paid_at')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dateTime('paid_at')
                    ->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Supprimer uniquement les colonnes qui existent
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('sales', 'paid_at')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('paid_at');
            });
        }

        if (Schema::hasColumn('sales', 'remaining_amount')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('remaining_amount');
            });
        }

        if (Schema::hasColumn('sales', 'paid_amount')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('paid_amount');
            });
        }
    }
};
