<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {

            $table->decimal('sold_price', 25, 3)->change();

        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {

            $table->decimal('sold_price', 15, 2)->change();

        });
    }
};
