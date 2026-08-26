<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {

            $table->string('engine_capacity')
                ->nullable()
                ->after('engine');

            $table->string('fuel_type')
                ->nullable()
                ->after('engine_capacity');

            $table->unsignedTinyInteger('doors')
                ->nullable()
                ->after('fuel_type');

            $table->unsignedTinyInteger('cylinders')
                ->nullable()
                ->after('doors');

            $table->string('tire_size')
                ->nullable()
                ->after('cylinders');

            $table->string('transmission')
                ->nullable()
                ->after('tire_size');

            $table->unsignedTinyInteger('seats')
                ->nullable()
                ->after('transmission');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {

            $table->dropColumn([
                'engine_capacity',
                'fuel_type',
                'doors',
                'cylinders',
                'tire_size',
                'transmission',
                'seats',
            ]);
        });
    }
};
