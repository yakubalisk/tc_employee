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
        Schema::create('financial_upgradations', function (Blueprint $table) {
            $table->id();
            $table->integer('sr_no');
            $table->string('empl_id');
            $table->date('promotion_date');
            $table->string('existing_designation');
            $table->string('upgraded_designation');
            $table->date('date_in_grade');
            $table->string('existing_scale');
            $table->string('upgraded_scale');
            $table->enum('pay_fixed', ['YES', 'NO']);
            $table->decimal('existing_pay', 10, 2);
            $table->decimal('existing_grade_pay', 10, 2);
            $table->decimal('upgraded_pay', 10, 2);
            $table->decimal('upgraded_grade_pay', 10, 2);
            $table->text('macp_remarks')->nullable();
            $table->integer('no_of_financial_upgradation');
            $table->enum('financial_upgradation_type', ['MACP', 'PROMOTION', 'ACP']);
            $table->string('region')->nullable();
            $table->string('department')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('empl_id');
            $table->index('promotion_date');
            $table->index('financial_upgradation_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_upgradations');
    }
};
