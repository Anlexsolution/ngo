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
        Schema::create('divisiondetails', function (Blueprint $table) {
            $table->id();
            $table->integer('divisionId');
            $table->integer('divisionHead')->nullable();
            $table->integer('dmName')->nullable();
            $table->integer('rcName')->nullable();
            $table->string('foName')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisiondetails');
    }
};
