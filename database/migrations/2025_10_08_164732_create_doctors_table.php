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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('empID');
            $table->string('name_of_doctor')->nullable();
            $table->string('registration_no')->nullable();
            $table->text('address')->nullable();
            $table->string('qualification')->nullable();
            $table->text('ama_remarks')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('empID');
            $table->index('name_of_doctor');
            $table->index('registration_no');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
