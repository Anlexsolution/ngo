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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('userType')->nullable();
            $table->string('fullName')->nullable();
            $table->string('nic')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('DOB')->nullable();
            $table->string('professional')->nullable();
            $table->integer('epfNo')->nullable();
            $table->string('gender')->nullable();
            $table->longText('permissions')->nullable();
            $table->string('division')->nullable();
            $table->string('village')->nullable();
            $table->string('active')->nullable();
            $table->string('memberPermision')->nullable();
            $table->string('profileImage')->nullable();
            $table->string('verify')->nullable();
            $table->integer('otpCode')->nullable();
            $table->integer('otpVerified')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
