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
        Schema::create('collectiondepositapproves', function (Blueprint $table) {
            $table->id();
            $table->integer('depositBy');
            $table->string('amount');
            $table->string('slipNo');
            $table->string('balance');
            $table->string('status')->nullable();
            $table->string('approveBy')->nullable();
            $table->string('approveDate')->nullable();
            $table->string('bank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collectiondepositapproves');
    }
};
