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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('memberId');
            $table->string('loanId');
            $table->integer('loanProductId');
            $table->string('principal');
            $table->string('loanterm')->nullable();
            $table->string('repaymentFrequency')->nullable();
            $table->string('interestRate')->nullable();
            $table->string('repaymentPeriod')->nullable();
            $table->string('per')->nullable();
            $table->string('interestType')->nullable();
            $table->integer('loanOfficer')->nullable();
            $table->string('loanPurpose')->nullable();
            $table->string('firstRepaymentDate')->nullable();
            $table->string('gurrantos')->nullable();
            $table->string('followerName')->nullable();
            $table->text('followerAddress')->nullable();
            $table->string('followerNic')->nullable();
            $table->string('followerNicIssueDate')->nullable();
            $table->string('followerPhone')->nullable();
            $table->string('followerProfession')->nullable();
            $table->integer('createStatus');
            $table->text('approval')->nullable();
            $table->string('loanStatus')->nullable();
            $table->integer('approvalStatus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
