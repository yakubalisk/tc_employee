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
        Schema::table('financial_upgradations', function (Blueprint $table) {
            $table->foreignId('employee_id')->constrained()->onDelete('cascade')->after('id');
        });
        Schema::table('financial_upgradations', function (Blueprint $table) {
            $table->dropColumn('sr_no');
            $table->dropColumn('empl_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
