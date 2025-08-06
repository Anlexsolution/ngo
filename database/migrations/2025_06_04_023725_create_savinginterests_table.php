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
        Schema::create('savinginterests', function (Blueprint $table) {
            $table->id();
             $table->string('savingId');
            $table->string('balance');
            $table->string('randomId');
            $table->integer('userId');
            $table->string('memberId');
            $table->string('type');
            $table->string('amount');
            $table->text('description')->nullable();
            $table->string('monthandyear');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savinginterests');
    }
};
