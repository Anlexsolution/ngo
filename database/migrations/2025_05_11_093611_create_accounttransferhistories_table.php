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
        Schema::create('accounttransferhistories', function (Blueprint $table) {
            $table->id();
            $table->string('userId');
            $table->string('fromAccountId');
            $table->string('toAccountId');
            $table->string('transferAmount');
            $table->string('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounttransferhistories');
    }
};
