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
        Schema::create('systemactivitylogs', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->string('type');
            $table->text('activity');
            $table->string('className');
            $table->string('ipAddress');
            $table->string('location');
            $table->string('country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('systemactivitylogs');
    }
};
