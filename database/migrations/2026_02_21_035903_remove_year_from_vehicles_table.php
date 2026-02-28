<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('vehicles', 'year')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->dropColumn('year');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('vehicles', 'year')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->integer('year')->nullable();
            });
        }
    }
};
