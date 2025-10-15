<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('empCode')->unique();
            // $table->string('empId')->unique();
            $table->string('name');
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER']);
            $table->enum('category', ['General', 'OBC', 'SC', 'ST']);
            $table->text('education')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('dateOfAppointment');
            $table->string('designationAtAppointment');
            $table->string('designationAtPresent');
            $table->string('presentPosting');
            $table->string('personalFileNo')->nullable();
            $table->string('officeLandline')->nullable();
            $table->date('dateOfBirth');
            $table->date('dateOfRetirement');
            $table->string('homeTown')->nullable();
            $table->text('residentialAddress')->nullable();
            $table->enum('status', ['EXISTING', 'RETIRED', 'TRANSFERRED'])->default('EXISTING');
            $table->boolean('promoted')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};