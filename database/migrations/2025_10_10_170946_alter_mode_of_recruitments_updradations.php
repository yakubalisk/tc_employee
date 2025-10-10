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
        Schema::table('mode_of_recruitments', function (Blueprint $table) {
            $table->dropColumn('empID');
        });
        Schema::table('mode_of_recruitments', function (Blueprint $table) {
            $table->foreignId('employee_id')->constrained()->onDelete('cascade')->after('PromotionID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mode_of_recruitments', function (Blueprint $table) {
            //
        });
    }
};
