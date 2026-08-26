<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(
            'ALTER TABLE `sales`
             MODIFY `sold_date` DATETIME NULL'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Sécurité avant retour à NOT NULL
        |--------------------------------------------------------------------------
        |
        | Si certaines ventes ont sold_date = NULL,
        | on leur remet une date avant de rétablir NOT NULL.
        |
        */

        DB::statement(
            'UPDATE `sales`
             SET `sold_date` = COALESCE(
                 `updated_at`,
                 `created_at`,
                 NOW()
             )
             WHERE `sold_date` IS NULL'
        );

        DB::statement(
            'ALTER TABLE `sales`
             MODIFY `sold_date` DATETIME NOT NULL'
        );
    }
};
