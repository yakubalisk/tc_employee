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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['Regular Promotion', 'MACP', 'ACP', 'Financial Upgradation']);
            $table->string('previous_designation');
            $table->string('new_designation');
            $table->date('effective_date');
            $table->text('remarks')->nullable();
            $table->string('approval_status')->default('Pending'); // Pending, Approved, Rejected
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->json('financial_details')->nullable(); // For financial upgradations
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('employee_id');
            $table->index('type');
            $table->index('effective_date');
            $table->index('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
