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
        Schema::create('loanschedules', function (Blueprint $table) {
            $table->id();
            $table->integer('loanId');
            $table->integer('month');
            $table->string('paymentDate');
            $table->float('monthlyPayment');
            $table->float('principalPayment');
            $table->float('interestPayment');
            $table->float('balance');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loanschedules');
    }
};
