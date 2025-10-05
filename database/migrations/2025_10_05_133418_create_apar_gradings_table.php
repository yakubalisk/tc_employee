<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('apar_gradings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('from_month');
            $table->integer('from_year');
            $table->string('to_month');
            $table->integer('to_year');
            $table->string('grading_type');
            $table->text('discrepancy_remarks')->nullable();
            $table->decimal('reporting_marks', 3, 1)->nullable();
            $table->decimal('reviewing_marks', 3, 1)->nullable();
            $table->string('reporting_grade')->nullable();
            $table->string('reviewing_grade')->nullable();
            $table->boolean('consideration')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            // Index for better performance
            $table->index(['employee_id', 'from_year', 'to_year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('apar_gradings');
    }
};