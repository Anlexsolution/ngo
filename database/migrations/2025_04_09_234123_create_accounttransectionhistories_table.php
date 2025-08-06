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
        Schema::create('accounttransectionhistories', function (Blueprint $table) {
            $table->id();
            $table->integer('collectionBy');
            $table->integer('memberId');
            $table->string('amount');
            $table->string('description')->nullable();
            $table->string('status');
            $table->integer('accountId');
            $table->string('balance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounttransectionhistories');
    }
};
