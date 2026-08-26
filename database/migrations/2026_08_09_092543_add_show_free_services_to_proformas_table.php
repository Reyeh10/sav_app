<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proformas', function (Blueprint $table) {

            $table->boolean('show_free_services')
                ->default(true)
                ->after('invoice_type');

        });
    }

    public function down(): void
    {
        Schema::table('proformas', function (Blueprint $table) {

            $table->dropColumn('show_free_services');

        });
    }
};
