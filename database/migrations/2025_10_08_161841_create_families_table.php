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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('empID');
            $table->string('name_of_family_member');
            $table->string('relationship');
            $table->date('date_of_birth');
            $table->text('dependent_remarks')->nullable();
            $table->string('reason_for_dependence')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('ltc')->default(false);
            $table->boolean('medical')->default(false);
            $table->boolean('gsli')->default(false);
            $table->boolean('gpf')->default(false);
            $table->boolean('dcrg')->default(false);
            $table->boolean('pension_nps')->default(false);
            $table->timestamps();

            // Indexes for better performance
            $table->index('empID');
            $table->index('relationship');
            $table->index('date_of_birth');
        });
    }

    public function down()
    {
        Schema::dropIfExists('families');
    }
};
