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
        Schema::table('economic_groups', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('flags', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('units', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('economic_groups', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('flags', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('units', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
