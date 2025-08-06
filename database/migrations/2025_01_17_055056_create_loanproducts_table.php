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
        Schema::create('loanproducts', function (Blueprint $table) {
            $table->id();
            $table->string('productName');
            $table->text('description')->nullable();
            $table->integer('defaultPrincipal')->nullable();
            $table->integer('minimumPrincipal')->nullable();
            $table->integer('maximumPrincipal')->nullable();
            $table->integer('defaultLoanTerm')->nullable();
            $table->integer('minimumLoanTerm')->nullable();
            $table->integer('maximumLoanTerm')->nullable();
            $table->string('repaymentFrequency')->nullable();
            $table->string('repaymentPeriod')->nullable();
            $table->integer('defaultInterest')->nullable();
            $table->integer('minimumInterest')->nullable();
            $table->integer('maximumInterest')->nullable();
            $table->integer('appprovalCount')->nullable();
            $table->string('per')->nullable();
            $table->string('active')->nullable();
            $table->string('interestType')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loanproducts');
    }
};
