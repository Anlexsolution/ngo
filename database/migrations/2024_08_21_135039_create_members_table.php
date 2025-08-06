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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('firstName');
            $table->string('lastName')->nullable();
            $table->string('address')->nullable();
            $table->string('nicNumber')->unique();
            $table->string('nicIssueDate')->nullable();
            $table->string('newAccountNumber');
            $table->string('oldAccountNumber')->nullable();
            $table->string('profession')->nullable();
            $table->string('gender');
            $table->string('maritalStatus');
            $table->string('phoneNumber')->nullable();
            $table->string('divisionId')->nullable();
            $table->string('villageId')->nullable();
            $table->string('smallGroupStatus')->nullable();
            $table->string('gnDivStatus')->nullable();
            $table->string('gnDivisionId')->nullable();
            $table->string('smallGroupId')->nullable();
            $table->string('followerName')->nullable();
            $table->string('followerAddress')->nullable();
            $table->string('followerNicNumber')->nullable();
            $table->string('followerIssueDate')->nullable();
            $table->string('dateOfBirth')->nullable();
            $table->string('profiePhoto');
            $table->string('signature');
            $table->string('uniqueId');
            $table->integer('deleted')->default(0);
            $table->integer('login')->default(0);
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
