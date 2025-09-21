<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('previous_posting');
            $table->string('new_posting');
            $table->date('transfer_date');
            $table->string('transfer_order_no')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Completed', 'Rejected'])->default('Pending');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->date('date_of_relieving')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('employee_id');
            $table->index('transfer_date');
            $table->index('status');
            $table->index('new_posting');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transfers');
    }
};