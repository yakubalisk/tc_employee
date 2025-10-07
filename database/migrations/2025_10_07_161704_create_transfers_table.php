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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id('transferId');
            $table->string('empID');
            $table->string('designation_id');
            $table->date('date_of_joining');
            $table->date('date_of_releiving');
            $table->string('transfer_order_no');
            $table->text('transfer_remarks')->nullable();
            $table->string('region_id');
            $table->date('date_of_exit')->nullable();
            $table->string('duration')->nullable();
            $table->string('department_worked_id');
            $table->string('transferred_region_id');
            $table->timestamps();

            // Indexes for better performance
            $table->index('empID');
            $table->index('date_of_joining');
            $table->index('region_id');
            $table->index('transferred_region_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
