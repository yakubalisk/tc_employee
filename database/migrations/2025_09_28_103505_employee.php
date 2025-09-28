<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// In your migration file
public function up()
{
    Schema::table('employees', function (Blueprint $table) {
        // Add new fields
        $table->string('profile_image')->nullable();
        $table->boolean('office_in_charge')->default(false);
        $table->string('promotee_transferee')->nullable();
        $table->string('pension_file_no')->nullable();
        $table->boolean('nps')->default(false);
        $table->integer('increment_month')->nullable();
        $table->boolean('probation_period')->default(false);
        $table->string('status_of_post')->nullable();
        $table->boolean('department')->default(false);
        $table->string('seniority_sequence_no')->nullable();
        $table->string('sddlsection_incharge')->nullable();
        $table->boolean('2021_2022')->default(false);
        $table->string('benevolent_member')->nullable();
        $table->boolean('2022_2023')->default(false);
        $table->boolean('increment_individual_selc')->default(false);
        $table->string('office_landline_number')->nullable();
        $table->boolean('increment_withheld')->default(false);
        $table->boolean('FR56J_2nd_batch')->default(false);
        $table->boolean('apar_hod')->default(false);
        $table->boolean('2023_2024')->default(false);
        $table->boolean('2024_2025')->default(false);
        $table->boolean('karmayogi_certificate_completed')->default(false);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
