<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('current_posting')->after('current_designation')->nullable();
            $table->date('last_transfer_date')->after('current_posting')->nullable();
            $table->foreignId('current_transfer_id')->after('last_transfer_date')->nullable()->constrained('transfers');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['current_posting', 'last_transfer_date', 'current_transfer_id']);
        });
    }
};