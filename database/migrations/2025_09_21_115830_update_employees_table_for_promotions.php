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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('current_designation')->after('status')->nullable();
            $table->date('last_promotion_date')->after('current_designation')->nullable();
            $table->foreignId('current_promotion_id')->after('last_promotion_date')->nullable()->constrained('promotions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
                Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['current_designation', 'last_promotion_date', 'current_promotion_id']);
        });
    }
};
