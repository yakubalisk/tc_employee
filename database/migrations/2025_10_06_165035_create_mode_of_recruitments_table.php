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
        Schema::create('mode_of_recruitments', function (Blueprint $table) {
            $table->id('PromotionID');
            $table->string('empID');
            $table->string('Designation_');
            $table->integer('Seniority_Number');
            $table->string('Designation');
            $table->date('Date_of_Entry');
            $table->string('Office_Order_No');
            $table->enum('Method_of_Recruitment', ['PR', 'DIRECT', 'DEPUTATION', 'CONTRACT']);
            $table->text('Promotion_Remarks')->nullable();
            $table->enum('Pay_Fixation', ['Yes', 'No']);
            $table->date('Date_of_Exit')->nullable();
            $table->string('GSLI_Policy_No')->nullable();
            $table->date('GSLI_Entry_dt')->nullable();
            $table->date('GSLI_Exit_dt')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('empID');
            $table->index('Method_of_Recruitment');
            $table->index('Date_of_Entry');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mode_of_recruitments');
    }
};
