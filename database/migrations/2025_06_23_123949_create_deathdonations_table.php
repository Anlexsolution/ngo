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
        Schema::create('deathdonations', function (Blueprint $table) {
            $table->id();
            $table->string('donationId')->unique();
            $table->string('memberId');
            $table->string('relativeId');
            $table->string('name');
            $table->string('remarks')->nullable();
            $table->string('userType');
            $table->integer('status')->default(0);
            $table->string('account')->nullable();
            $table->string('cheqNo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deathdonations');
    }
};
