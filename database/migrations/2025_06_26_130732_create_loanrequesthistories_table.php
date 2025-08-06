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
        Schema::create('loanrequesthistories', function (Blueprint $table) {
            $table->id();
            $table->integer('loanRequestId');
            $table->integer('approvedBy');
            $table->integer('approvedStatus');
            $table->string('approvedRemarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loanrequesthistories');
    }
};
