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
        Schema::create('loanrepayments', function (Blueprint $table) {
            $table->id();
            $table->integer('loanId');
            $table->integer('memberId');
            $table->integer('userId');
            $table->date('repaymentDate');
            $table->string('repaymentAmount');
            $table->string('lastLoanBalance');
            $table->string('interest');
            $table->string('principalAmount');
            $table->string('transectionId')->unique();
            $table->string('savingAmount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loanrepayments');
    }
};
