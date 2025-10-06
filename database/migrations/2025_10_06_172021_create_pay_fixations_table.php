<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pay_fixations', function (Blueprint $table) {
            $table->id();
            $table->string('empl_id');
            $table->date('pay_fixation_date');
            $table->decimal('basic_pay', 10, 2);
            $table->decimal('grade_pay', 10, 2)->nullable();
            $table->integer('cell_no');
            $table->string('revised_level');
            $table->text('pay_fixation_remarks')->nullable();
            $table->string('level_2');
            $table->timestamps();

            // Indexes for better performance
            $table->index('empl_id');
            $table->index('pay_fixation_date');
            $table->index('revised_level');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pay_fixations');
    }
};
